## TODO

Legend: **High priority** Normal priority *Future idea*

### Frontpage
- More varied layout
- Call to actions
- Destination feature(s)
- *Carousels*
- *Active content (based on ranking)*

### Auth

- **Login + legacy passwords**
- **Register**
- **Password reminder**
- **Roles**
- **Auth Mailers**
- **Auth tests**
- Registration spam prevention (Mollom?)
- FB login
- Permissions

### Security

- **Content sanitization** (input/output)

### Search

- Algolia? $49/m / ES (hosting) / **Zend Search**

### Image

- **Image processing**
- **Image URLS**
- **Image uploads**

### Content

- **Content add/edit/delete forms**
- **Filtering**
- Content status: published/unpublished/draft/deleted?
- Destination and tag autocomplete in filter/edit
- Previews
- *Content expiration*

### Movies

- *Movie field on add/edit*
- *Movie embed*

### Buysell

- Extra fields?
- Merge with forum?

### Travelmates 

- Extra fields?
- Expiration

### Flights

- Company logos / images
- Extra fields?
- Expiration

### Offers

- **Offer display**
- **Extra fields?**
- Offer add/edit/delete forms
- Offer scheduler

### Destinations

- Baum (tree handling)
- Destination pages

### Comment

- **Comment add/edit/delete forms**
- Content status: published/unpublished/draft/deleted?

### Messages

- Message add/edit/delete forms
- Mailer
- Message tests with seeds, fix 8991
- From collections hacks to real SQL

### Follow

- Follow toggle/remove
- Mailer

### Users

- Commerical users

### Viewed

- Viewed status on content, comments, **messages**

### Activity

- *Activity tracking*

### Ranking

- *content, comment, user ratings*

### Forms

- **Form helper**
- Date widget
- Time widget
- Delete confirmations

### Routes

- complete the routes + auth middleware?
- content/index/{type} > content/{type}/all
- content/{id} > content/{type}/{id} // resouce controller?

### Legacy paths

- Redirect

### Ads

- Google DFB / Custom
- New ad sizes?

### Convert

- convert legacy paths
- convert user permissions
- convert content status
- convert comment status
- convert subscription status
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

### DB

- users: unique name / email ?
- foreign keys

### Models

- nl2br to body
- date accessors?

### Views

- user header
- naming: _ vs partials vs index vs list vs element ...
- date: partial? model?
- other data on grids

### Controllers

- cache

### Other

- sitemap
- favicon
- RSS feed
- GA tracker
- Other trackers?
