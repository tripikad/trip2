Legend: **High priority** Normal priority *Future idea*

## TODO


### Content

- **What to do with extra fields (buysell, travelmates, flight offers, offers)**


### Convert

- convert private messages from blocked users?
- convert private message sending setting in profile
- convert private message read statuses
- convert follow status

- convert static pages
-- http://trip.ee/node/1534
-- http://trip.ee/node/972
-- http://trip.ee/node/25151
-- http://trip.ee/node/22125

- convert non-forum followed pages?
- convert photo: Mitte-reisipildid?
- flights: regexp price from the title
- misc,expat,buysell -> new term or /content/forum to multitype
- commercial users?
- ó -> õ
- 

### Libraries

### Viewed status

https://andrisreinman.com/efektiivne-ip-kaunter/

### Tests

https://github.com/bertramtruong/mailtrap

### Packages

https://packagist.org/packages/texy/texy
https://packagist.org/packages/mews/purifier

## JS

Dropzone.js






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
- **Content status: published/unpublished**
- **Comment published/unpublished**
- content, comment rating
- **Forum filtering fixes: autocomplete, autosubmit**
- **sanitize content input**
    - limited HTML for body (content, message, comment)
        a, em, i, strong, b, img, br
    - clear attributes
    - no HTML in other fields incl titles (content, user, message, destination, carrier, comment, topic)
    - use middleware sanitizer?
- **Register mails**
    https://github.com/laracasts/Email-Verification-In-Laravel
- "Not yet registred?" links
- remove hardcoded form urls from views
- **Publish / unpublish content/comments**
- **fix double bcrypt on password reset**
- ConvertOldUsers
- hbert everywhere? /content/forum/69831
- sanitization:
    - remove html in titles
    - limit html in body
- StatOldUsers: first created nodes and comments
- Users* 
    uid < 61
    uid > 60
- do not convert content from ?!* users -> re-enable
- convert: fix double run on taxonomy relations
- Does email view work?
- @section('subheading')
- comment trans: .field.
- inline styles to CSS
- card to flexbox
- convert
    - comment titles?
    - message titles?
    - content by anonymous users?
    - /uurimus|küsitlus|uuring term/
    - /töö/
    - remove UPPERASE
    - filter frontimg tag from blog posts
    - Reisiveeb?
    - remove <!--break-->
- markup change
    - \n<u>...</u> -> <h4></h4>
    - \n<strong>...</strong> -> <h4></h4>
- convert user profiles
- convert subscription status
- convert havebeen / wanttogo
- Terms:
https://packagist.org/packages/baum/baum
