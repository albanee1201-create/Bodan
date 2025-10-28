Bodan Portal - Results Management Module

Files included:
- database_additions.sql  -> SQL to create 'results' table
- teacher/upload_result.php -> Form to upload single result (teacher)
- teacher/upload_results_csv.php -> Bulk CSV upload (teacher)
- teacher/view_results.php -> Teacher view of uploaded results
- student/view_results.php -> Student view of their results
- student/download_report.php -> Download PDF report (Dompdf optional)
- admin/manage_results.php -> Admin overview of all results

Install steps:
1. Import database_additions.sql into your portal database (run via phpMyAdmin).
2. Copy the files into your existing portal structure, preserving paths.
3. Ensure includes/db.php and includes/security.php exist and are configured.
4. Install Dompdf if you want PDF generation: run 'composer require dompdf/dompdf' in project root and upload vendor/.
5. Teachers must be registered users with role='teacher'. Students must exist with role='student' and valid email.
6. Use teacher/upload_result.php to add individual results or upload CSV via teacher/upload_results_csv.php.

CSV format for bulk upload:
student_email,subject,score,term,session,remark

Grades are calculated automatically:
70+ => A, 60-69 => B, 50-59 => C, 45-49 => D, <45 => F

The PDF report includes a signature line and school header. If Dompdf is not installed, the report page will render HTML in browser.
