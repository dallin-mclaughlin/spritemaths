SELECT qs.title AS 'Question', qs.question_summary AS 'Question Summary', yl.year_level AS 'Year Level', tp.topic AS 'Topic' 
FROM laravel.questions qs
JOIN laravel.topics tp ON (qs.topic_id = tp.id)
JOIN laravel.year_levels yl ON (qs.year_level_id = yl.id);
