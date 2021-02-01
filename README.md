# Feed transform: tags into entry body

This script takes a feed and amends any `<category>` tags in the feed items into their text.

It exists for one reason only: NetNewsWire doesn't support displaying tags, and some tumblr blogs really need them to be legible.

This doesn't bother with any caching, because I'm expecting it to live somewhere obscure where the only traffic is NetNewsWire occasionally requesting an update, so every request will refetch the feed from the server.

## Usage

Check it out on a server and do `composer install`

Subscribe to a feed in your feed reader in the form: `https://example.com/feedtransform/?feed=https://example.com/feed`
