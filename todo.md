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
- **Register**


## Functionality TODO

### Frontpage

- More varied layout
- *Call to actions?*
- *Destination feature / search*
- *Carousel*
- *Active content (based on ranking)*

### User

- User history: collection based
- *User history: activity feed based*

### Content

- **Forum siltering**
- **Content status: published/unpublished/draft/deleted**
- Destination and tag autocomplete in index / edit
- Content type conversion for admins
- *Content expiration*

### News

- Easy image add
- Preview
- *WVSIWVG (What Veigo Sees Is What Veigo gets)*

### Buysell

- What to do with extra fields?
- Merge with forum?

### Travelmates 

- What to do with extra fields?
- Expiration?

### Flight offers

- What to do with extra fields?
- Company logos / images
- Expiration?

### Videos

- *Video field on content forms (what types?)*
- *Video embed*

### Offers

- **Offer filter**
- **Extra fields?**
- Offer add/edit/delete forms
- Offer scheduler

### Polls and surverys

- Poll functionality?
- Survey functionality?

### Comment

- **Comment add/edit/delete forms**
- **Content status: published/unpublished/draft/deleted**
- Comment moderation tools: quick unpublish

### Destinations

- Destination feature pages
- Baum (tree handling)

### Tags

- Convert from "topics" to "tags"

### Carriers

- Defined in config?

### Search

- **Destination autocomplete**
- **Choose Provider:**
    - local Zend Search
    - Algolia? $49/m
    - Self-hosted Elasticsearch $10-$20
    - Link to Google onsite search

### Messages

- **Message add/edit/delete forms**
- **Mail messages**
- Create Message tests with seeds
- From collections hacks to real queries

### Content ranking

- content, comment, *user* ratings

### Following

- Enable disable mailing
- Remove item

### Activity feeds

- *Create activity feeds*

### Ads

- Google DFB / Custom made

## Technology TODO

### Auth

- **Password reminder**
- **Roles**
- Permissions
- Legacy Drupal password hasher / mass password renewal?
- *Registration spam prevention (Mollom?)*
- *FB login*
- "Not yet registred?" links

### DB

- users: unique name / email ?
- foreign keys for pivot tables / comments

### Routes

- **auth middleware / controller AC **

### Models

- **sanitize content input**
    - no HTML in titles
    - limited HTML for body
        a, em, i, strong, b, img, br
    - clear attributes
- **sanitize content output + nl2br**

### Views

- Date formatting: in partial? in model?
- Does email view work?
- @section('subheading')

### SASS

- Lato @import

### Controllers

- **Cache of popular views**
- *Full cache pipeline*

### Image pipeline

- **Image processing**
- **Image URLs**
- **Image uploads**
- fallback image(s) in /public/icons

### Forms

- **Access control per field**
- Date widget
- Time widget
- Delete confirmations

### Legacy paths

- what to do with long legacy paths without ".html" ?

### Viewed status

- Viewed status on content, comments, **messages**

### Following

- *Harmonize Following / Subscribing / Bookmarking concepts*

### Stat

- OldUsers: first created nodes and comments

### Convert

- ConvertOldUsers
- ConvertUnpublishedComments ($latest - 1 month)
- **convert content status**
- **convert comment status**
- convert subscription status
- convert havebeen / wanttogo?
- convert commerical users?
- convert polls?
- convert subscriptions?
- small fixes:
    - comment titles?
    - do not convert content from ?!* users
    - convert photo: Mitte-reisipildid?
    - limit CLI parameter
    - files CLI parameter
    - fix double run on taxonomy relations
    - filter frontimg tag from blog posts
    - flights: regexp price from the title
    - misc -> new term?
    - expat -> new term?
    - buysell -> new term?
    - Reisiveeb?
    - /uurimus|küsitlus|uuring term/
    - /töö/

### Translations

- Add translations
- Carbon translations?

### Other

- sitemap
- favicon
- RSS feed
- GA tracker
- Other trackers?

### SQL

- Unique user statuses?
