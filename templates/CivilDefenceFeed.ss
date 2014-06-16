<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:nzemergency="http://www.civildefence.govt.nz/rss-namespace" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>$Page.RSSTitle</title>
		<description>$Page.RSSDescription</description>
		<lastBuildDate>$Date</lastBuildDate>
		<% if RSSItems %>
			<% control RSSItems %>
			<item>
				<title>$Title</title>
				<description>$Description</description>
				<pubDate>$PubDate</pubDate>
				<guid>$GUIDHash</guid>
				<% if Emergency %>
					<nzemergency:type>$getEmergencyReal</nzemergency:type>
				<% end_if %>
				<% if UpdateDate %>
					<atom:updated>$UpdateDate</atom:updated>
				<% end_if %>
			</item>
			<% end_control %>
		<% end_if %>
	</channel>
</rss>