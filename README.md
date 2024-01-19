# MyDiscussionForum Website

## The Team

- Colin Lefter
- Jarod Parish
- Abdirahman Hajj Salad

## Project Description

Our project models a modern online discussion platform where users have the freedom to engage in online conversation by creating posts and adding to discussion threads. Registered users can create posts on a diverse range of topics, building their reputation on the platform through engagement with others. All users can browse and search for specific topics, or explore trending topics through a responsive and intuitive interface. Unregistered users can browse existing posts and threads, but are required to create an account in order to leave comments on, like and share posts.

The forum will consist of user generated threads, categorized by use of tags. Each thread will represent a linear format with every response(or comment) following in chronological order. For organization, responses can be linked through a post's id. This supports navigation of specific conversation in a large or busy thread.

Administrators of the platform will have access to a comprehensive suite of tools that enable them to view core analytics for the platform. A variety of site-wide aggregated data will be made available, such as the number of daily, monthly and quarterly active users, number of registered accounts and metrics by category. In addition, administrators will also have the ability to query user account data when providing customer service. Having access to user account data is also crucial to ensuring the security of the platform and preventing harmful content from being published. Content moderation through use of sub-administrator accounts(moderators) allows approved users to moderate content to a safe extent, whilst providing an appropriate level of privacy.



## Requirements List

### Website user’s objectives:

- **(Our addition)** Browse posts by topic
- **(Our addition)** Emoji support
- **(Our addition)** User reputation tracking
- Browse discussions without registering
- Search for items/posts by keyword without registering
- Register at the site by providing their name, e-mail and image
- Allow user login by providing user id and password
- Create and comment when logged into the site
- Users are required to be able to view/edit their profile

### Website administrator’s objectives:

**Level 1 (Moderator):**

- **(Our addition) User Warnings and Temporary Bans:** Allow moderators to issue warnings to users for minor infractions and enforce temporary bans for repeated or more severe violations
- **(Our addition) Tag Management:** Enable moderators to add, edit, or remove tags from posts to ensure content is correctly categorized and easier to find
- **(Our addition) Community Engagement Metrics:** Give moderators access to basic analytics about user engagement, such as the number of active users, popular topics, and trending discussions

**Level 2 (Senior Admin):**

- **(Our addition) Advanced Analytics Dashboard:** Access to in-depth analytics, including user behavior patterns, post engagement statistics, and growth trends over time
- **(Our addition) Site Configuration and Customization:** Enable senior admins to modify site settings, layout, and features, including the ability to implement major updates or redesigns
- **(Our addition) Emergency Broadcast System:** Implement a system for urgent communications with all users, like site maintenance announcements or important updates
- Search for user by name, email or post
- Enable/disable users
- Edit/remove posts items or complete posts 

### Minimum Functional Requirements:

- Hand-styled layout with contextual menus (i.e. when a user has logged on to the site, menus reflect the change). Layout frameworks are not permitted other than Bootstrap (see above).
- 2 or 3-column layout using appropriate design principles (i.e. highlighting nav links when hovered over, etc) responsive design
- Form validation with JavaScript
- Server-side scripting with PHP
- ata storage in MySQL
- Appropriate security for data
- Site must maintain state (user state being logged on, etc)
- Responsive design philosophy (minimum requirements for different non-mobile display sizes)
- AJAX (or similar) utilization for asynchronous updates (meaning that if a discussion thread is updated, another user who is viewing the same thread will not have to refresh the page to see the update)
- User images (thumbnail) and profile stored in a database
- Simple discussion (topics) grouping and display
- Navigation breadcrumb strategy (i.e. users can determine where they are in threads)
- Error handling (bad navigation)

### Additional Requirements

- Search and analysis for topics/items
- Hot threads/hot item tracking
- Visual display of updates, etc (site usage charts, etc)
- Activity by date
- Tracking (including utilizing tracking API or your own with visualization tools)
- Collapsible items/treads without page reloading
- Alerts on page changes
- Admin view reports on usage (with filtering)
- Styling flourishes
- Responsive layout for mobile
- Tracking comment history from a user’s perspective
- Accessibility, through use of user friendly design heuristics
