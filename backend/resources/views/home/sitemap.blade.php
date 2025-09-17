<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <url>
          <loc>https://www.vijaykumardvk.com/</loc>
          <lastmod>2022-08-24T14:51:01+00:00</lastmod>
          <changefreq>weekly</changefreq>
          <priority>1.00</priority>
        </url>
    @forelse ($projects as $value)
        <url>
            <loc>{{ url('portfolio/'.$value->slug) }}</loc>
            <lastmod>{{ \Carbon\Carbon::parse($value->created_at)->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @empty
    @endforelse
</urlset>
