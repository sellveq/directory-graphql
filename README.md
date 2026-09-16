# ScandiPWA DirectoryGraphQl

Fork of [scandipwa/directory-graphql](https://github.com/scandipwa/directory-graphql) 1.0.2, maintained by Selveq for Magento 2.4.9 and PHP 8.3. Module name and namespace are unchanged, and the package replaces `scandipwa/directory-graphql` at every version, so it installs as a drop-in replacement. Selveq is not affiliated with or endorsed by Scandiweb.

## What it does

- Answers `is_state_required` on both the `countries` and the `country` queries, always `true` or `false`.
- Reads the field from `general/region/state_required` in store scope, so it follows the `Store` header.
- Leaves `countries` cacheable through core's own `Country\Identity`, tags and all.
- Invalidates that cache when `general/region/state_required` is saved, which core's tag generator does not do.

## Install

```sh
composer require selveq/directory-graphql
bin/magento setup:upgrade
```

## License

[OSL-3.0](LICENSE), the license of the original work. Scandiweb's copyright notices are kept in every file, and each file Selveq changed carries a `Modifications © Selveq` notice.
