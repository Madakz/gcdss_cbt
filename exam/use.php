SELECT sub.id AS subject, que.id AS question, ansa.answer AS answer FROM subjects sub , questions que, answers ansa WHERE que.id = ansa.question_id AND ansa.subject_id= sub.id AND sub.id='1'   //replace 1 with the subject_id





SELECT sub.id AS subject_id, que.id AS question_id, que.answer AS answer FROM subjects sub , questions que WHERE que.subject_id= sub.id AND sub.id='1'



SELECT sub.id AS subject_id, que.id AS question_id, que.answer AS answer, ansa.answer AS stu_answer FROM subjects sub , questions que, answers ansa WHERE que.id = ansa.question_id AND que.subject_id= sub.id AND sub.id='1'   //display question answer and student answer