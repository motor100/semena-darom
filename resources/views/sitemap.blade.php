<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
  <url>
    <loc>https://semena-darom.ru/</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
  </url>
  @foreach($products as $prd)
    <url>
      <loc>https://semena-darom.ru/catalog/{{ $prd->slug }}</loc>
      <lastmod>{{ now()->toAtomString() }}</lastmod>
      <changefreq>weekly</changefreq>
      <priority>0.9</priority>
    </url>
  @endforeach
  <url>
    <loc>https://semena-darom/catalog/</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>https://semena-darom/o-kompanii/</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>https://semena-darom/dostavka-i-oplata/</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>https://semena-darom/otzyvy/</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>https://semena-darom/kontakty/</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>https://semena-darom/novinki/</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>https://semena-darom/akcii/</loc>
    <lastmod>{{ now()->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
</urlset>