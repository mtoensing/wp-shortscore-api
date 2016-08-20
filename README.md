# wp-shortscore-api

json read-only api for shortscore data by shortscore id (comment id)

API endpoint is this: `https://shortscore.org/?get_shortscore=[shortscore_id]`

The Shortscore ID is the wordpress comment id. 

## example request

https://shortscore.org/?get_shortscore=374 

will output this:

```{
 shortscore: {
    id: "374",
    userscore: "10",
    content: "To keep it short: One of the best games, I&#039;ve ever played.",
    url: "https://shortscore.org/game/dark-souls/#comment-374"
 },
 game: {
    id: "745",
    url: "https://shortscore.org/game/dark-souls/",
    shortscore: "9.5",
    count: "4"
 }
 }```
