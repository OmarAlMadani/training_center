Training center project

This project includes Web and DB development.

Each student must model individually the DB.

The Web development (including triggers) is done by teams of 2, and is limited to features 1.1 and 1.2. Ajax (and then REST Web services) will be used when useful. User friendlliness (not design) is taken in account.

Features

A training center wants some tools to make its processes efficent and simple. The SI is used by students, trainers, administration, these three groups forming the members, and candidates (persons who want to become student and who fill a candidature form).

Students project management.
The center bases a large part of its training on projects. It is therefore important to manage easily these ones.
Each trainer can record a multi-team project, which will summarize in a single place the work of all teams.
Acceptance tests:
A project has a title, an owner, a creation datetime, a deadline, a subject, and the concerned class.
The project owner is the member who has created it.
The creation date is set by the system.
The deadline is greater than the creation date.
The owner can modify the title, the deadline or the subject.
The project has a page, with the details, the list of teams, and the students in the class not yet in a team.
Each team and member mention has a link to the related page.
Each student can create a team for a multi-team project, so that the trainer is freed from this task, and students can organize themselves.
Acceptance tests:
A team has an owner, a creation date, and an optionnal summary.
The owner is set automatically as the team creator.
The owner must belong to the class concerned by the project.
The creation date is set by the system.
The team owner can add members of the class as team members.
The owner can remove members (useful in case of mistakes).
The owner can update the summary.
Each team has a dedicated Web page, with details and members.
The page provides links to members and owner profile.
Each team member can put documents on the team page, so that the trainer and the team members have at any time a global view.
Acceptance tests:
Only the trainer and members of this team have read access to the contents.
Team members provide a complete relative path to the document they put on the server.
The system sets automatically a creation/update date and the author (the member who puts the document).
The complete directory structure can be browsed.
Documents can not be put after the project deadline.
Students management.
Everyone can sign up as a candidate on the Web site, so that the administration is freed from this tedious and error prone task.
Acceptance tests:
First and last name, address, zip code and town, email and password, one or more phone numbers (including a mobile one) must be filled.
The email and password must be confirmed (two input fields for each one).
The security level of the password is displayed at each character stroke.
Email is unique: two candidates can not have the same one.
First and last name with address, zip code, town and first phone number is unique.
When the form is submitted, a confirmation mail including a Web link is sent to the candidate.
The candidate must confirm his registration through this link before the day after (24h).
Subscriptions not confirmed in due time are removed from the database, in order to prevent garbage data.
The candidate receives then an id wich identifies him/her.
Each member can edit his/her profile, to make it always up to date and to free the administration to do that
Acceptance tests:
The member must sign in before editing his/her profile.
A link to the profile edition is included in a menu displayed on each page.
A member can not edit the profile of another member.
The administration can edit the profile of every student.
The member can send or update his/her face picture, whose size is limited to 100 ko.
The mandatory fields of the sign up form can not be emptied.
The email addresse can be changed, but must remain unique among all the member emails.
Each member can renew his/her password if it is forgotten, in order to ensure the service even if he/she has forgotten it.
Acceptance tests:
A link to do that is displayed in a connection area on each page.
The member must enter his/her email address.
A link is sent to him/her by email.
When clicking the link, a page with the new password to be input is displayed.
The new password must be input twice to avoid input errors.
