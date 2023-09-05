<?PHP
	class User{
		private ?int $userID=null;
		private ?string $username=null ;
		private ?string $password=null ;
		private ?string $status="unbanned";
		private ?string $role = "user";

		function __construct( string $username,  string $password){
		
			$this->username=$username;
			$this->password=$password;
			
		}

	

		
		function getUserID(): int{
			return $this->userID;
		}
		function getUsername(): string{
			return $this->username;
		}
		function getPassword(): string{
			return $this->password;
		}
		
		function getRole(): string{
			return $this->role;
		}


		function setUsername(string $username): void{
			$this->username=$username;
		}

		function setRole(string $role): void{
			$this->role=$role;
		}

	}
?>