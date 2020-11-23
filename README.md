# RubyRagage
1. get all statuses, not repeating, alphabetically ordered 

_`SELECT DISTINCT status 
FROM tasks 
ORDER BY status`_

2.get the count of all tasks in each project, order by tasks count 
  descending
  
_`SELECT projects.id ,  COUNT(tasks.id) AS COUNTS
FROM tasks RIGHT JOIN projects
ON tasks.project_id = projects.id
GROUP BY projects.id
ORDER BY COUNTS DESC`_


3.get the count of all tasks in each project, order by projects 
  names 


_`SELECT projects.name
FROM tasks RIGHT JOIN projects
ON tasks.project_id=projects.id
GROUP BY projects.id
ORDER BY name`_

4.get the tasks for all projects having the name beginning with 
  "N" letter 
  
  _`SELECT projects.id , tasks.name , tasks.id
  FROM tasks RIGHT JOIN projects
  ON tasks.project_id = projects.id
  WHERE tasks.name LIKE 'N%'`_

5.get the list of all projects containing the 'a' letter in the middle of 
  the name, and show the tasks count near each project. Mention
  that there can exist projects without tasks and tasks with 
  project_id = NULL
  
`  SELECT projects.name, COUNT(tasks.id) 
  FROM projects, tasks 
  WHERE projects.name LIKE '%a%' 
  AND projects.id = tasks.project_id 
  GROUP BY projects.name`
  
6.get the list of tasks with duplicate names. Order alphabetically

`SELECT * FROM tasks 
WHERE name IN (SELECT name FROM tasks GROUP BY name HAVING COUNT(name)>1 ) 
ORDER BY name ASC`

7.get list of tasks having several exact matches of both name and 
  status, from the project 'Garage'. Order by matches count

`SELECT tasks.name, tasks.status, COUNT(tasks.id) as count
FROM tasks JOIN projects
ON tasks.project_id = projects.id
WHERE projects.name = 'Garage'
GROUP BY tasks.name, tasks.status`


8.get the list of project names having more than 10 tasks in status 
  'completed'. Order by project_id

`SELECT projects.name, COUNT(tasks.project_id) as count
FROM tasks JOIN projects
ON projects.id = tasks.project_id
WHERE tasks.status = 'yes'
GROUP BY tasks.project_id
HAVING count > 10
ORDER BY projects.id ; `
