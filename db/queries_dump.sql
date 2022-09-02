-- view midwife

-- SELECT `id`, `first_name`, `last_name`, `mid_initial`, `details_id`,
SELECT u.id, CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, u.email, 
-- CASE 
-- WHEN u.status = 0 THEN 'Inactive' 
-- ELSE 'Active'
-- END AS status, 
IF(u.status=0, 'Inactive', 'Active') AS status,
d.contact_no,d.b_date,b.health_center FROM users as u,details as d,barangay as b WHERE u.admin = 0 AND d.id=u.details_id AND d.barangay_id=b.id;

-- appointments 

SELECT a.date AS a_date,  tm.name AS t_type, tm.description AS t_description, tmr.date AS t_date, m.name AS m_name, m.description AS m_description, m.date as m_date
FROM appointment AS a, treat_med_record AS tmr, treat_med AS tm, 
	(SELECT tmr1.id AS mr_id, tmr1.date, tm1.name, tm1.description
    FROM treat_med_record AS tmr1, treat_med AS tm1
    WHERE tm1.category=0 AND tmr1.treat_med_id=tm1.id) AS m
WHERE 3=a.patient_id AND a.date>='2022-07-31' AND a.treatment_record_id=tmr.id AND tmr.treat_med_id=tm.id AND a.medicine_record_id=m.mr_id 
ORDER BY a.date DESC LIMIT 1