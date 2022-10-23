-- view midwife

-- SELECT `id`, `first_name`, `last_name`, `mid_initial`, `details_id`,
SELECT u.id, CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, u.email, 
-- CASE 
-- WHEN u.status = 0 THEN 'Inactive' 
-- ELSE 'Active'
-- END AS status, 
IF(u.status=0, 'Inactive', 'Active') AS status,
d.contact_no,d.b_date,b.health_center FROM users as u,details as d,barangay as b WHERE u.role = 0 AND d.id=u.details_id AND d.barangay_id=b.id;

-- appointments 

SELECT a.date AS a_date,  tm.name AS t_type, tm.description AS t_description, tmr.date AS t_date, m.name AS m_name, m.description AS m_description, m.date as m_date
FROM appointment AS a, treat_med_record AS tmr, treat_med AS tm, 
	(SELECT tmr1.id AS mr_id, tmr1.date, tm1.name, tm1.description
    FROM treat_med_record AS tmr1, treat_med AS tm1
    WHERE tm1.category=0 AND tmr1.treat_med_id=tm1.id) AS m
WHERE 3=a.patient_id AND a.date>='2022-07-31' AND a.treatment_record_id=tmr.id AND tmr.treat_med_id=tm.id AND a.medicine_record_id=m.mr_id 
ORDER BY a.date DESC LIMIT 1




/*
SELECT u.id AS id, CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, u.email, d.contact_no, health_center,  details_id, med_history_id FROM users as u, details as d, barangay as b 
WHERE  d.id=u.details_id AND (d.barangay_id=2 OR d.barangay_id=5 ) AND d.barangay_id=b.id  
*/
/* 

*/

-- appointments when they match deleted patients 

SELECT (IF(name IS NULL, "Deleted Patient",name)) as name, (IF(email IS NULL, "Deleted Patient", email))as email, (IF(contact_no IS NULL, "Deleted Patient", contact_no)) as contact_no,
(IF(health_center IS NULL, "Deleted Patient", health_center)) as health_center,
(IF(details_id IS NULL, "Deleted Patient", details_id)) as details_id,
(IF(med_history_id IS NULL, "Deleted Patient", med_history_id)) as med_history_id, 
a.date
FROM appointment AS a
LEFT JOIN (SELECT u.id AS id, CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, u.email, d.contact_no, health_center,  details_id, med_history_id FROM users as u, details as d, barangay as b 
WHERE  d.id=u.details_id AND (d.barangay_id=2 OR d.barangay_id=5 ) AND d.barangay_id=b.id) AS p
ON a.patient_id=p.id;



-- infant to vaccines 
-- SELECT CONCAT(first_name, " ", (), " ", last_name) AS name FROM `infant`
/*
SELECT CONCAT(first_name, IF(middle_name IS NULL, "", CONCAT(" ", middle_name)), " ", last_name) infant_name, date, type
FROM infant
LEFT JOIN vaccinations
	USING (infant_id);
*/

-- name measles penta polio pneumococcal 
SELECT CONCAT(first_name, IF(middle_name IS NULL, "", CONCAT(" ", middle_name)), " ", last_name) infant_name, 
	me.date measles, pe.date penta, po.date polio, pn.date pneumococcal
FROM infant 
LEFT JOIN (SELECT infant_id, date FROM vaccinations WHERE type=1) AS me 
	USING (infant_id)
LEFT JOIN (SELECT infant_id, date FROM vaccinations WHERE type=2) AS pe
	USING (infant_id)
LEFT JOIN (SELECT infant_id, date FROM vaccinations WHERE type=3) AS po
	USING (infant_id)
LEFT JOIN (SELECT infant_id, date FROM vaccinations WHERE type=4) AS pn
	USING (infant_id)

-- count vaccinations 
SELECT infants.infant_id, CONCAT(first_name, 
    IF(middle_name IS NULL OR middle_name='', '', 
        CONCAT(' ', SUBSTRING(middle_name, 1, 1), '.')), 
    ' ', last_name) infant_name, c_vaccinations
FROM infants 
LEFT JOIN 
	(SELECT infant_id, COUNT(infant_id) c_vaccinations FROM infant_vac_records GROUP BY infant_id) c
    USING (infant_id)

SELECT CONCAT(first_name, IF(middle_name IS NULL, "", CONCAT(" ", middle_name)), " ", last_name) infant_name, m.date measles, p.date penta, po.date polio
FROM infant 
LEFT JOIN 
	measles m USING(infant_id)
LEFT JOIN 
	penta p USING(infant_id)
LEFT JOIN 
	polio po USING(infant_id)

SELECT CONCAT(first_name, 
    IF(middle_name IS NULL OR middle_name='', '', 
        CONCAT(' ', SUBSTRING(middle_name, 1, 1), '.')), 
    ' ', last_name) infant_name, 
	me.date measles, pe.date penta, po.date polio, pn.date pneumococcal
FROM infants 
LEFT JOIN (SELECT infant_id, date FROM infant_vac_records WHERE type=1) AS me 
	USING (infant_id)
LEFT JOIN (SELECT infant_id, date FROM infant_vac_records WHERE type=2) AS pe
	USING (infant_id)
LEFT JOIN (SELECT infant_id, date FROM infant_vac_records WHERE type=3) AS po
	USING (infant_id)
LEFT JOIN (SELECT infant_id, date FROM infant_vac_records WHERE type=4) AS pn
	USING (infant_id)