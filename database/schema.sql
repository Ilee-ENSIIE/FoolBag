
---------------------------
---------------------------
---- HELPER FUNCTIONS -----
---------------------------
---------------------------

/**
 * Generate a good enough random string for stub data
 * Do not use for any security purpose
 * @see http://www.simononsoftware.com/random-string-in-postgresql/
 * @param int Size of the desired string
 * @return string A "random" string
 */
CREATE OR REPLACE FUNCTION random_string(int)
RETURNS text
AS $$ 
  SELECT array_to_string(
    ARRAY (
      SELECT substring(
        '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' FROM (random() *26)::int FOR 1)
      FROM generate_series(1, $1) ), '' ) 
$$ LANGUAGE sql;


---------------------------
---------------------------
------- APP SCHEMA --------
---------------------------
---------------------------


create table test(
    id serial primary key,
    whatever varchar not null
);



---------------------------
---------------------------
-------- APP DATA ---------
---------------------------
---------------------------

-- insert 100 random strings of length 20
insert into test (whatever) 
    select random_string(20)
    from generate_series(1, 100)
;