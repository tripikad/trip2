## Functionality TODO

Legend: **High priority** Normal priority *Future idea*

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

- **Content add/edit/delete forms**
- **Filtering**
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

- Sample ads for prototyping
- Google DFB / Custom made
- New ad sizes?

## Technology TODO

### Auth

- **Login**
- **Register**
- **Password reminder**
- **Auth mailer translation**
- **Roles**
- Permissions
- Legacy Drupal password hasher / mass password renewal?
- *Registration spam prevention (Mollom?)*
- *FB login*

### DB

- users: unique name / email ?
- foreign keys for pivot tables / comments

### Routes

- complete the routes + auth middleware?
- content/index/{type} > content/{type}/all
- content/{id} > content/{type}/{id} // resouce controller?

### Models

- **sanitize content input**
- **sanitize content output + nl2br**

### Views

- **Views access control**
- **View access control tests**
- Naming: _ vs partials vs index vs list vs element vs component
- Date formatting: in partial? in model?
- Does email view work?

### SASS

- Lato @import

### Controllers

- **Cache of popular views**
- *Full cache pipeline*

### Image pipeline

- **Image processing**
- **Image URLs**
- **Image uploads**

### Forms

- **Access control per field**
- Date widget
- Time widget
- Delete confirmations

### Legacy paths

- Redirect legacy paths

### Viewed status

- Viewed status on content, comments, **messages**

### Following

- *Harmonize Following / Subscribing / Bookmarking concepts*

### Convert

- **convert user permissions**
- **convert content status**
- **convert comment status**
- convert legacy paths
- convert subscription status
- convert havebeen / wanttogo?
- convert commerical users?
- small fixes:
    - convert photo: Mitte-reisipildid?
    - limit parameter
    - files parameter
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

### Other

- sitemap
- favicon
- RSS feed
- GA tracker
- Other trackers?