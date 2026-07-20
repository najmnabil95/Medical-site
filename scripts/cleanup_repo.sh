#!/usr/bin/env bash
set -euo pipefail

# cleanup_repo.sh
# Usage: Run this locally from a clone of the repository to remove tracked
# large/editor artifact files and generated caches, then push the cleanup commit.
# This script does NOT rewrite Git history. See the BFG/git-filter-repo section
# at the bottom if you want to permanently remove files from history.

echo "This script will:
 - remove tracked .vsix files from the index
 - remove tracked generated caches (storage/framework/views, bootstrap/cache)
 - commit the removals and push to the current branch
Please make sure you have a clean working tree and have pushed any local work before running."

read -p "Continue? [y/N] " confirm
if [[ "$confirm" != "y" && "$confirm" != "Y" ]]; then
  echo "Aborted by user."
  exit 1
fi

# Remove tracked VSIX files
if git ls-files --error-unmatch "*.vsix" >/dev/null 2>&1; then
  echo "Removing tracked .vsix files from index..."
  git rm --cached --ignore-unmatch "*.vsix"
fi

# Remove tracked generated view/cache files
for path in storage/framework/views bootstrap/cache; do
  if [ -e "$path" ]; then
    if git ls-files --error-unmatch "$path" >/dev/null 2>&1; then
      echo "Removing tracked $path from index..."
      git rm -r --cached --ignore-unmatch "$path"
    fi
  fi
done

# Commit and push
git add .gitignore || true
if git diff --cached --quiet; then
  echo "No index changes to commit."
else
  git commit -m "chore: remove tracked artifact files (vsix, generated caches) and rely on .gitignore"
  echo "Pushing changes to origin/$(git rev-parse --abbrev-ref HEAD)"
  git push
fi

echo "Cleanup commit created and pushed (if there were tracked files)."

cat <<'BFG'

---
If you need to remove the large files from the repository history (completely purge them):
1) Install BFG Repo-Cleaner (https://rtyley.github.io/bfg-repo-cleaner/)
2) Mirror the repo locally:
   git clone --mirror git@github.com:YOUR_USER/YOUR_REPO.git
3) Run BFG to delete all .vsix files:
   java -jar bfg.jar --delete-files "*.vsix" YOUR_REPO.git
4) Clean and push:
   cd YOUR_REPO.git
   git reflog expire --expire=now --all && git gc --prune=now --aggressive
   git push --force

Warning: Rewriting history is destructive and requires coordination with all collaborators.
BFG
