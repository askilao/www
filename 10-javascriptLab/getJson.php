<?PHP
$data = file_get_contents('https://www.ntnu.no/web/studier/alle?p_p_id=studyprogrammelistportlet_WAR_studyprogrammelistportlet&p_p_lifecycle=2&p_p_state=normal&p_p_mode=view&p_p_resource_id=allStudies&p_p_cacheability=cacheLevelPage&p_p_col_id=column-1&p_p_col_count=1');
header('Content-Type: application/json');

echo json_encode($data);