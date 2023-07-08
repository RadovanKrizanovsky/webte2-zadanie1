# WEBTE2 1. Assignment SS 2022/2023
#(Entire assignment is repost from my other profile)

This is an assignment for the WEBTE2 course for the academic year 2022/2023.

## General Instructions
- The tasks should be optimized for the latest versions of Google Chrome and Firefox.
- Assignments are always due at midnight on the day before the class.
- Late submission of assignments will result in a reduction of points.
- Create a new database for each assignment unless stated otherwise.
- Submit the assignment as a zip file, including the parent directory. Use the naming convention `idStudent_lastname.zip`.
- The zip archive should contain the following files:
  - `index.php` (main script)
  - `config.php` (configuration file placed in the same directory as `index.php`)
  - `idStudent_lastname.sql` (database dump, if applicable)
  - `idStudent_lastname.doc` (technical report, if submitted)
- Include a note with the link to the functional assignment hosted on your assigned server (`siteXX.webte.fei.stuba.sk`).

## Assignment Description
1. Familiarize yourself with the contents of the attached files: `osoby.csv`, `oh.csv`, `umiestnenia.csv` (found in the attachments - `csv.zip`). The first file contains data about Slovak Olympic winners, the second file contains data about the Olympic Games, and the third file contains data about the placements of our Olympic winners in the Olympics.

2. Create a database for this assignment and populate it with three tables using the provided files. Pay attention to the correct encoding in the database to display proper diacritics. Make sure to establish proper relationships between the tables using foreign keys and set appropriate constraints for deletion.

3. Display a table on the webpage showing the names of our Olympic winners along with:
   - The year they won the medal
   - The location of the Olympics
   - The type of Olympics (Summer or Winter)
   - The discipline in which they won the medal

   If a person has won a gold medal multiple times, there should be multiple rows for that person in the table. The column headers "Last Name," "Year," and "Type" should be clickable. Clicking on a header should sort the table by size or alphabetically. Clicking on the "Type" header should also consider the year of the Olympics as a secondary sorting criterion.

4. Display a highlighted table on the webpage showing the top 10 most successful athletes based on the number of gold medals they have won.

5. When a name in the displayed table is clicked, a page should open showing all the placements of that athlete in the Olympics. From this page, there should be an option to go back to the list of athletes. Create a user-friendly navigation system for easy access.

6. All relevant columns in the tables should be sortable and searchable. Additionally, implement pagination, such as displaying 10 or 20 records per page, and provide an option to show all records (this functionality can be implemented using libraries like DataTables, Tabulator, Handsontable, etc.).

   Bonus: If you implement server-side pagination in addition to client-side pagination (using a library like DataTables) and make sure that sorting works across the entire table (not just the currently displayed page), you can earn a bonus point.

7. Create a private area on the webpage where users can log in using one of two options:
   - Regular registration: Users enter their name, surname, email, login, and password, and these details are stored in the database.
   - Google account: When registering with a Google email, redirect the user to the Google login page.

8. Implement two-factor authentication (2FA) for regular registration, and store encrypted passwords in the database using an appropriate encryption algorithm. Choose a unique identifier for each user, either login or email.

9. Store information about individual user logins in the database. Create a table to record user logins, including their login time and login method (registration, Google).

   In the database, also track user activities such as insert, delete, or modification operations and record the table and record they worked on.

10. After successful login, display user information and a suitable welcome message on the application's homepage. The information about the logged-in user should remain visible at all times. Ensure that users can also log out of the application. Unauthenticated users should not have access to the pages meant for logged-in users or administrators. If an unauthenticated user attempts to access those pages, redirect them to the login page.

11. Provide the following functionalities for logged-in users:
   - Add a new athlete and their placements (add the athlete first, and then add their placements). Prevent adding duplicate athletes.
   - Modify athlete details and their placements (when modifying, prefill the form fields with data from the database).
   - Delete placements of athletes and athletes themselves (when deleting an athlete from the table that contains personal information, make sure to delete all related rows in the placements table).

12. Perform input validation during registration, login, and when inserting or modifying records. Both frontend and backend validation are necessary.

13. Provide appropriate user notifications (e.g., toasts, alerts) after successfully inserting or modifying records.

14. Implement a visually appealing application using cascading stylesheets (CSS) and make it responsive. Consider the overall user experience and design. We recommend using CSS frameworks (such as Bootstrap) and JavaScript frameworks (such as DataTables) or graphical templates. Make sure to comply with the licenses of the resources used.

For inspiration on how the athletes' table and their placements could look, refer to the following demos:
- [User Management Data Table](https://www.tutorialrepublic.com/snippets/preview.php?topic=bootstrap&file=user-management-data-table)
- [CRUD Data Table for Database with Modal Form](https://www.tutorialrepublic.com/snippets/preview.php?topic=bootstrap&file=crud-data-table-for-database-with-modal-form)

## Conclusion
This assignment covers various tasks related to creating a web application that displays and manages data about Olympic winners. Follow the instructions provided and make sure to implement the required functionalities. Good luck with your assignment!
