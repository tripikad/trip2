Legend: **High priority** Normal priority *Future idea*

## Done

- convert legacy paths
- **convert user permissions**
- **Content add/edit/delete forms**
- Sample ads for prototyping
    - sizes
        - narrow 250x75 / 30%
        - wide 630x75 / 11.9%
        - square 250x250 / 100%
- Naming: _ vs partials vs index vs list vs element vs component
- content/index/{type} > content/{type}/all
- content/{id} > content/{type}/{id}
- **Login**
- **Comment add/edit/delete forms**
- Add translations
- **Roles**
- users: unique name / email ?
- **auth middleware / controller AC**
- Forum filtering
- **Destination feature pages**
- **Image processing**
- **Image URLs**
- **Image uploads**
- **Password reminder**
- **Message add/edit/delete forms**

## TODO

### Auth

- **Register mails**
    https://github.com/laracasts/Email-Verification-In-Laravel
- Legacy Drupal password hasher / mass password renewal?
- "Not yet registred?" links
- remove hardcoded form urls from views
- *Registration spam prevention (Mollom?)*
- *FB login*
- *Permissions*

### Content

- **Forum filtering fixes: autocomplete, autosubmit**
- **Content status: published/unpublished**
- **What to do with extra fields (buysell, travelmates, flight offers, offers)**
- Content delete
- Destination and tag autocomplete in index / edit
- *Content type conversion for admins*
- *Previews?*
- *Expiration?*

### Videos

- *Video field on content forms (what types?)*
- *Video embed*

### Offers

- Remake or pull from old site?
- Offer add/edit/delete forms
- Offer scheduler

### Comments

- **Comment published/unpublished**
- Comment delete

### Destination

- Generic autocomplete widget + view composer

### Tags

- Convert from "topics" to "tags"

### Carriers

- Defined in config?

### Search

- Choose Provider:
    - local Zend Search
    - Algolia? $49/m
    - Self-hosted Elasticsearch $10-$20
    - Link to Google onsite search

### Messages

- **Message title accessor**
- Mail messages
- Create Message tests with seeds
- From collections hacks to real queries
- *Message blocking*
- *Message edit/delete forms?*

### Content ranking

- content, comment, *user* ratings

### Following

- Enable disable mailing
- Remove item

### Activity feeds

- *Create activity feeds*

### Ads

- **Google DFB**
- Custom made

### DB

- foreign keys for pivot tables / comments

### Models

- **sanitize content input**

    - limited HTML for body (content, message, comment)
        a, em, i, strong, b, img, br
    - clear attributes

    - no HTML in other fields incl titles (content, user, message, destination, carrier, comment, topic)

    - use middleware sanitizer?

### Views

- Date formatting: in partial? in model?
- Does email view work?
- @section('subheading')
- comment trans: .field.
- inline styles to CSS
- components/content/blog/front -> feature

### Controllers

- **Cache of popular views**
- CommentController@store: $id? $type

### Image pipeline

- fallback image(s) in /public/icons
- fix file move() override

### Forms

- Access control per field
- Date widget
- Time widget
- Delete confirmations

### Legacy paths

- what to do with long legacy paths without ".html" ?

### Viewed status

- Viewed status on content, comments, **messages**
https://andrisreinman.com/efektiivne-ip-kaunter/

### Following

- *Harmonize Following / Subscribing / Bookmarking concepts*

### Stat

- StatOldUsers: first created nodes and comments

### Convert

- ConvertOldUsers
- ConvertUnpublishedComments ($latest - 1 month)
- convert subscription status
- convert havebeen / wanttogo?
- convert commerical users?
- convert polls?
- convert subscriptions?
- small fixes:
    - hbert everywhere? /content/forum/69831
    - content by anonymous users?
    - comment titles?
    - message titles?
    - do not convert content from ?!* users -> re-enable
    - convert photo: Mitte-reisipildid?
    - fix double run on taxonomy relations
    - filter frontimg tag from blog posts
    - flights: regexp price from the title
    - misc -> new term?
    - expat -> new term?
    - buysell -> new term?
    - Reisiveeb?
    - /uurimus|küsitlus|uuring term/
    - /töö/
- sanitization:
    - remove html in titles
    - limit html in body
    - remove <!--break-->
    - remove UPPERASE

### Libraries

- Atom feed for http://trip.ee/index.atom
https://packagist.org/packages/roumen/feed

- Content sanitizing:
https://packagist.org/packages/texy/texy
https://packagist.org/packages/mews/purifier

- Terms:
https://packagist.org/packages/baum/baum

- Sitemap:
http://packalyst.com/packages/package/roumen/sitemap

- Carbon localizations:
https://packagist.org/packages/laravelrus/localized-carbon

### Other

- favicon
- GA tracker

### Tests

- User page test