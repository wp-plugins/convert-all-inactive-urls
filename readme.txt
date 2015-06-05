Convert All Inactive URLS
================================================
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