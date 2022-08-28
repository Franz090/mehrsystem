-- view midwife

-- SELECT `id`, `first_name`, `last_name`, `mid_initial`, `details_id`,
SELECT u.id, CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, u.email, 
-- CASE 
-- WHEN u.status = 0 THEN 'Inactive' 
-- ELSE 'Active'
-- END AS status, 
IF(u.status=0, 'Inactive', 'Active') AS status,
d.contact_no,d.b_date,b.health_center FROM users as u,details as d,barangay as b WHERE u.admin = 0 AND d.id=u.details_id AND d.barangay_id=b.id;

