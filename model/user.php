<?PHP
	class User{
		private ?int $userID=null;
		private ?string $username=null ;
		private ?string $password=null ;
		private ?string $role = null;

		function __construct( string $username,  string $password, string $role){
		
			$this->username=$username;
			$this->password=$password;
			$this->role=$role;
			
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