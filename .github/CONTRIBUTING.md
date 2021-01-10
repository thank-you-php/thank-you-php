# Contributing guidelines

* Fork this repository over GitHub

* Add your signature to the list, commit and push to your fork:

  ```bash
  git add .
  git commit -m "New signature by @yourusername"
  git push origin
  ```

* Open a new pull request

* Make sure the linked username in the signature matches exactly the GitHub
  handler of the account that opens the pull request. This is the way to ensure
  the signature belongs to who has written the patch.

* The `sort` *nix command can be used for sorting the list:

```sh
LC_ALL=utf8 sort -f <file>
```
