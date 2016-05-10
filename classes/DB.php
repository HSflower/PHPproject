<?
if(! class_exists("DB") ){

	class DB
		{ 

		var $servername = "localhost";
		var $dbName		= "buyrunicm" ;

		var $username 	= "buyrunicm";
		var $password 	= "toltol2199**";
		var $charset	= "utf8" ;

		var $db;				//db connection
		var $result ;			//result set
		var $debug = true ;		//is debug??
	
	// Create connection : MySQLi Object-Oriented
	// var $conn = new mysqli($servername, $username, $password);
	// Create connection : MySQLi Procedural

		function DB () 
		{
			$this->connect_db($this->servername, $this->username, $this->password,$this->dbName,$this->charset) ; 
		}
		
		/*
			터이터 베이스에 접속하는 함수
		*/
		function connect_db($servername, $username, $password, $username, $charset) 
		{ 
			$this->db = new mysqli($servername, $username, $password, $username ); 

			// 20091222 added by nukiboy
			$this->db->set_charset( $charset ) ;
			
			//접속실패시 메시지
			$this->check_connect() ;
		}
	/*
		function mysqli_connect() { 
			$this->$db = mysqli_connect( $servername, $username, $password, $dbName ); #//db connection
		}
*/
		function connect_error() { 
		// Check connection
			 if ($db->connect_error) {
			     die("Connection failed: " . $db->connect_error);
			} 
			echo "Connected successfully";
		}
		/* 
		 db에서 select 쿼리를 실행하는 함수 
		*/ 
		function query($query) 
		{
			if( $this->check_connect() == false )
				return ;
		
			$this->result = @mysqli_query($this->db,$query) or die( ( $this->debug ) ? mysqli_error( $this->db ) : "Error : excute query" ) ;
		}

		function check_connect()
		{
			if( mysqli_connect_errno() ) 
			{
				$this->trace_error("Connect failed. db 접속이 유효하지 않습니다."); 
				return false ;
			}

			return true ;
		}

		/*
			db에 다중 쿼리를 실행한다
		*/
		function multi_query($query)
		{
			return @mysqli_multi_query($this->db,$query) or die( ( $this->debug ) ? mysqli_error( $this->db ) : "Error : excute multi query" ) ;
		}

		/* 
			 db 에서 insert, delect, update 쿼리를 실행하는 함수 
			 return : 적용된 rows 수, 에러가 있다면, -1를 반환 
		*/ 
		function update($query) 
		{
			try
			{
				$this->query($query) ;
				return mysqli_affected_rows($this->db) ;
			}
			catch(Exception $e)
			{
				throw new Exception("update error") ;
			}
		} 

		/* 
			 select query된 result set을 반환한다.  
			 꼭 필요한 경우 사용하고 보통은 next_fetch()를 사용하도록 한다.  
		*/ 
		function get_result() 
		{ 
			return $this->result; 
		} 

		function mysql_insert_id()
		{
			return mysqli_insert_id($this->db) ;
		}

		function getValue($sql,$col)
		{
			$row = $this->getRow($sql) ;
			return $row[$col] ;
		}

		function getRow($sql) 
		{
			$this->query($sql) ;
			
			$row = null ;
			if( 1 <= $this->getNum())
				$row = $this->next_row() ;
			
			$this->result->close(); 

			return $row ;
		}
		
		function getMultiRow($sql)
		{
			$this->multi_query($sql) ;
			return $this->next_row() ;
		}
		
		//배열 가져오기
		function getArray($sql)
		{
			
			$this->query($sql) ;
			
			$arrResult = Array() ;

			$i = 0 ;
			
			while($row = $this->next_row()){

				$arrResult[$i] = $row ;
				$i ++ ;
			}

			$this->result->close(); 
			
			return $arrResult ;
		}


		//배열 가져오기
		function getMultiArray($sql)
		{

			$isResult = $this->multi_query($sql) ;

			if( $isResult ) 
			{
				$pack = Array() ;
				$multiNum = 0 ;

				do 
				{ 
					if ($this->result = $this->db->store_result()) 
					{ 
						$set = Array() ;
						$i = 0 ;
						while( $row = $this->next_row() ) 
						{ 
							$set[$i] = $row ;
							$i ++ ;
						}
						
						$this->result->close(); 

						$pack[$multiNum] = $set ;
						$multiNum ++ ;
					} 
				} 
				while( $this->next_result() ); 
			}
			
//			$this->db->close(); 

			return $pack ;

		}

		
		/* 
			 에러 메세지를 출력한다. 
		*/ 
		function trace_error($msg) 
		{
			if( $this->debug )
			{

				echo "</UL></DL></OL>\n"; 
				echo "</TABLE></SCRIPT>\n"; 
				$text  = "<FONT COLOR=\"#ff0000\"><P>Error: $msg : </p>"; 
				$text .= mysql_error(); 
				$text .= "</FONT>\n"; 
				die($text); 

			}
		} 

		/* 
			 db 와 연결된 자원을 반납한다. 
			 페이지 output이 끝나면 자동적으로 접속이 끊기지만, 명시적으로 
			 db접속이 끊기는걸 넣어주는게 좋습니다. 
			 //Example (MySQLi Object-Oriented)
			$conn->close();
			//Example (MySQLi Procedural)
			mysqli_close($conn);  
		*/ 
		function destroy() 
		{
			
			if(is_resource($this->result)) mysql_free_result($this->result);  
			mysql_close($this->db); 
		}

		
		/* 
			 결과셋의 다음 행 반환
		*/ 
		function next_row() 
		{ 
			$assoc = $this->result->fetch_assoc() ;

			return $assoc ;
		}

		// 20091222 added by nukiboy
		function getNum()
		{
			return mysqli_num_rows($this->result)  ;
		}

	}
}
