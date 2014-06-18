<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:nzemergency="http://www.civildefence.govt.nz/rss-namespace" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>$Page.RSSTitle</title>
		<description>$Page.RSSDescription</description>
		<lastBuildDate>$Date</lastBuildDate>
		<% if RSSItems %>
		<% loop RSSItems %>
		<% if $getEmergencyReal %>
			<item>
				<title>$Title</title>
				<description>$Description.XML</description>
				<pubDate>$PubDate</pubDate>
				<guid>$UniqueID</guid>
				<nzemergency:type>$getEmergencyReal</nzemergency:type>
				<% if UpdateDate %>
				<atom:updated>$UpdateDate</atom:updated>
				<% end_if %>
			</item>
		<% end_if %>
		<% end_loop %>
		<% end_if %>
	</channel>
</rss>