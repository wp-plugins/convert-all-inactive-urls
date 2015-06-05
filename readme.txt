=== Plugin Name ===
Contributors: Aang Kunaefi (programmermaster)
Donate link: http://example.com/
Tags: convert link, create link, clickable url
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin will convert the entire inactive urls becomes active urls as links. This means that only the entire inactive urls which will be converted.

== Description ==

This plugin will convert the entire inactive urls becomes active urls as links. This means that only the entire inactive urls which will be converted into an active url. You also can set up unwanted domains that will not be converted as links and display as normal text.

Example 1

This is a basic rule, when you don't change any setting all inactive urls will be converted as links with default target attribute is _blank : target="_blank".

When a URL is detected does not begin with http: // or https: //, the plugin will add http: // automatically on the url in the href attribute.

google.com is the best search engine, 
followed by yahoo.com and 
bing.com and 
http://yandex.com
will be :

<a href="http://google.com" target="_blank">google.com</a> is the best search engine, 
followed by <a href="http://yahoo.com" target="_blank">yahoo.com</a> and 
<a href="http://bing.com" target="_blank">bing.com</a> and 
<a href="http://yandex.com" target="_blank">http://yandex.com</a>.

You can set up the default settings of the rel attribute and target attribute to the url which will be converted. In addition you can also set your url with a particular domain that does not want to be converted as a link.

Say you have made adjustments as follows:

Rel attribute is nofollow
Target attribute is _self
Blocked domains: yahoo.com and yandex.com
google.com is the best search engine, 
followed by yahoo.com and 
bing.com and 
http://yandex.com
will be :

<a href="http://google.com" rel="nofollow" target="_self">google.com</a> is the best search engine, 
followed by yahoo.com and 
<a href="http://bing.com" rel="nofollow" target="_self">bing.com</a> and 
http://yandex.com.

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets 
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png` 
(or jpg, jpeg, gif).
2. This is the second screen shot

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.