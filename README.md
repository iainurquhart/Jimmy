Image tracking module that logs user data whenever an image is called, born from wanting to get *some* stats on views of my add-ons on Devot:ee.

For example:

<img src="http://mysite.com/?ACT=45&id=5" alt="" />

Will log IP address, user agent, timestamp and referrer.

Your image files should be stored in /third_party/jimmy/images

Very basic, unsupported, work in progress.