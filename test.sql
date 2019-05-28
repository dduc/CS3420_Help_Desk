CREATE VIEW personal_info AS SELECT c.fname, c.lname, c.address, c.city, c.state, c.zip, c.phone, c.business_name,c.fax,c.email FROM client AS c;

CREATE VIEW problems AS SELECT p.category, p.description FROM problem AS p and client AS c CROSS JOIN problem_status ps WHERE ps.ps_id = p.problem_id and p.client_id = c.client_id;

CREATE VIEW tickets AS SELECT t.priority, t.solution, ts.status FROM ticket AS t CROSS JOIN ticket_status ts WHERE ts.ticket_id = t.ticket_it
d
