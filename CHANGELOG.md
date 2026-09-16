# Changelog

## 2.0.0

Forked from `scandipwa/directory-graphql` 1.0.2. Module name and namespace are unchanged, and the package replaces `scandipwa/directory-graphql` at every version, so it installs as a drop-in replacement.

- `is_state_required` is resolved per field, so `countries` and `country` both answer it.
- `is_state_required` is always `true` or `false`, never `null`.
- `countries` is cacheable again, through core's own `Country\Identity`.
- Saving `general/region/state_required` invalidates the country cache, which core's tag generator does not do.
- Removed: the `<preference>` over core's `Countries` resolver, so core's resolver runs unmodified.
- Removed: the re-declared `countries` query and the six `Country` fields that only restated core's, so the schema declares just the field this module adds.
- Removed: `setup_version` from `module.xml`, which declared a schema version for a module that ships no setup scripts.
