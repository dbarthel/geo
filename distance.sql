DELIMITER //
CREATE FUNCTION `GetDistance`(
 lat1  numeric (10,6),
 lon1  numeric (10,6),
 lat2  numeric (10,6),
 lon2  numeric (10,6)
) RETURNS decimal(10,5)
    READS SQL DATA
BEGIN
  DECLARE  x  decimal (20,10);
  DECLARE  pi  decimal (21,20);
  SET  pi = 3.14159265358979323846;
  SET  x = sin( lat1 * pi/180 ) * sin( lat2 * pi/180  ) + cos(
 lat1 *pi/180 ) * cos( lat2 * pi/180 ) * cos(  abs( (lon2 * pi/180) -
 (lon1 *pi/180) ) );
  SET  x = acos( x );
  RETURN  ( 1.852 * 60.0 * ((x/pi)*180) ) / 1.609344;
END //
DELIMITER ;