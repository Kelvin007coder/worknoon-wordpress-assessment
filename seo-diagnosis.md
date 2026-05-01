# SEO Diagnosis: New Worknoon Website Not Indexing After Sitemap Submission

## Overview

A newly launched website failing to index despite sitemap submission is a common but
solvable issue. Below is a systematic troubleshooting guide covering all likely causes.

---

## 1. Crawlability Tests

Before Google can index a page, it must be able to crawl it. Start here.

### Steps:
1. **URL Inspection Tool** (Google Search Console)
   - Go to Search Console → URL Inspection → enter homepage URL
   - Check: "URL is not on Google" vs. crawl errors

2. **Fetch as Google**
   - In Search Console, use "Test Live URL" to see what Googlebot sees
   - Look for blocked resources (CSS, JS, images)

3. **Manual Crawl Simulation**
   ```
   curl -A "Googlebot/2.1 (+http://www.google.com/bot.html)" https://worknoon.com
   ```
   - If you get a non-200 response, the server is blocking the bot

4. **Check Server Response Codes**
   - Use tools like httpstatus.io or Screaming Frog to check for:
     - 301/302 redirect chains
     - 404 or 410 errors on key pages
     - 500 server errors

5. **Crawl Budget Check**
   - For large sites, low crawl budget can delay indexing
   - Check crawl stats in Search Console → Settings → Crawl Stats

---

## 2. Canonical Checks

Canonical tags tell Google which URL is the "master" version. Misconfigured canonicals
prevent indexing of the intended pages.

### Common Issues:
- Self-referencing canonical pointing to the wrong URL
  ```html
  <!-- Wrong: -->
  <link rel="canonical" href="https://worknoon.com/home/" />
  <!-- Right: -->
  <link rel="canonical" href="https://worknoon.com/" />
  ```
- Non-HTTPS canonical on an HTTPS site
- Canonical pointing to a staging or development URL
- WordPress plugins (Yoast/Rank Math) misconfigured and outputting wrong canonicals

### How to Audit:
- View page source → search for `rel="canonical"`
- Use Screaming Frog → Directives tab → filter by canonical
- Check for canonical chains (A → B → C) which confuse Googlebot

---

## 3. Robots.txt & No-Index Audit

This is the most common reason for a site not indexing — it is literally told not to be.

### Robots.txt Check:
- Visit: `https://worknoon.com/robots.txt`
- Look for problematic directives:
  ```
  # Dangerous — blocks entire site:
  User-agent: *
  Disallow: /

  # Also dangerous — blocks Googlebot specifically:
  User-agent: Googlebot
  Disallow: /
  ```
- The correct minimal config for a public site:
  ```
  User-agent: *
  Disallow:
  Sitemap: https://worknoon.com/sitemap.xml
  ```

### WordPress-Specific Issue:
- In WordPress Settings → Reading → check **"Discourage search engines from indexing
  this site"** — this adds a `noindex` tag to all pages. This is a very common cause
  of new sites not indexing.

### No-Index Meta Tag Audit:
- Check page source for:
  ```html
  <meta name="robots" content="noindex" />
  ```
- Audit using Screaming Frog: Directives → filter "noindex"
- Check Yoast/Rank Math settings at both site-wide and per-page level

### X-Robots-Tag HTTP Header:
- Some hosting providers or CDNs inject `X-Robots-Tag: noindex` in HTTP headers
- Check with: `curl -I https://worknoon.com` and look at response headers

---

## 4. Sitemap Structure Issues

A malformed or inaccessible sitemap prevents Google from discovering URLs efficiently.

### Sitemap Validation Steps:

1. **Accessibility Check**
   - Visit `https://worknoon.com/sitemap.xml` — it must return a 200 status
   - If 404 or redirect, the sitemap isn't reachable

2. **Sitemap Format Validation**
   - Validate at: [www.xml-sitemaps.com/validate-xml-sitemap.html](https://www.xml-sitemaps.com/validate-xml-sitemap.html)
   - Common issues:
     - Invalid XML characters
     - Missing `<?xml version="1.0" encoding="UTF-8"?>` declaration
     - URLs in sitemap using HTTP instead of HTTPS
     - URLs not matching canonical versions

3. **Search Console Sitemap Report**
   - Search Console → Sitemaps → check status
   - "Success" with 0 URLs discovered = sitemap found but URLs excluded
   - "Couldn't fetch" = accessibility issue
   - "Has errors" = XML format problem

4. **WordPress Plugin Configuration**
   - Yoast SEO: SEO → General → Features → XML Sitemaps → ON
   - Rank Math: Sitemap Settings → verify post types are enabled
   - Ensure the sitemap includes: posts, pages, categories (as needed)

5. **Sitemap Size**
   - Max 50,000 URLs per sitemap file; use sitemap index for larger sites
   - Check for unnecessarily included URLs: tag pages, author pages, media attachments

---

## 5. Page Speed Indexing Blockers

While page speed isn't a direct indexing requirement, severe issues can prevent Google from
rendering and fully indexing pages.

### Key Issues:

1. **Core Web Vitals & Rendering**
   - Pages with heavy JavaScript that blocks rendering may not be fully indexed
   - Use Google Search Console → URL Inspection → "Test Live URL" → View Rendered Page
   - Compare rendered HTML to raw HTML — missing content = rendering issue

2. **Server Response Time (TTFB)**
   - If TTFB > 600ms consistently, Googlebot may abandon crawls
   - Test: Google PageSpeed Insights, GTmetrix
   - Fix: Hosting upgrade, caching plugin (WP Rocket, W3 Total Cache), CDN

3. **Large Page Size**
   - Pages > 2MB may not be fully crawled
   - Compress images, minify CSS/JS, enable GZIP/Brotli compression

4. **Render-Blocking Resources**
   - Undeferred JavaScript prevents Googlebot from seeing full content
   - Use `defer` or `async` on non-critical scripts

5. **Hosting & Uptime**
   - If the server returns 5xx errors during Googlebot's crawl, indexing fails
   - Check uptime logs; consider a more reliable host if errors are frequent

---

## 6. Search Console Debugging Steps

Google Search Console is the primary tool for diagnosing indexing issues.

### Step-by-Step Debugging Workflow:

1. **Verify Ownership**
   - Ensure the site is verified in GSC (HTML tag, DNS record, or GA)
   - If recently migrated, re-verify

2. **Coverage Report**
   - GSC → Indexing → Pages
   - Review each category:
     | Status | Meaning |
     |---|---|
     | Indexed | ✅ All good |
     | Crawled - currently not indexed | Google crawled but chose not to index |
     | Discovered - currently not indexed | Google knows page exists but hasn't crawled |
     | Excluded by noindex | `noindex` tag found |
     | Blocked by robots.txt | robots.txt is blocking crawl |
     | Redirect error | Redirect chain or loop |
     | Not found (404) | Page doesn't exist |
     | Soft 404 | Page returns 200 but appears empty/error |

3. **Request Indexing**
   - URL Inspection → "Request Indexing" for important pages
   - Note: This is a request, not a guarantee; typically takes days to weeks

4. **Check Manual Actions**
   - GSC → Security & Manual Actions → Manual Actions
   - If a manual penalty exists, indexing is blocked until resolved

5. **Security Issues**
   - GSC → Security & Manual Actions → Security Issues
   - Hacked sites are de-indexed; fix malware before re-submitting

6. **Links Report**
   - A new site with zero external backlinks may take longer to index
   - Submit key URLs manually; build initial links from owned properties
     (social profiles, directory listings)

7. **Resubmit Sitemap**
   - GSC → Sitemaps → Remove the old sitemap → Re-add it
   - This forces a fresh crawl of the sitemap

---

## Quick Diagnosis Checklist

| Check | Tool | Expected Result |
|---|---|---|
| Robots.txt not blocking | Browser | `Disallow:` (blank) |
| WordPress discourage setting off | WP Admin | Unchecked |
| No `noindex` tags on key pages | View Source / Screaming Frog | No noindex meta tags |
| Sitemap accessible | Browser | 200 OK, valid XML |
| Sitemap submitted to GSC | Search Console | Status: Success |
| Canonical URLs correct | View Source | Matches intended URL |
| No Manual Actions | Search Console | No issues detected |
| Server returning 200 | curl / GTmetrix | 200 OK, fast TTFB |
| Pages renderable by Googlebot | GSC URL Inspection | Rendered page matches source |
| External links exist | Ahrefs / GSC Links | At least 1–5 external links |
