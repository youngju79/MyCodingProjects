package cs201Project;

public class User {
	private int userID;
	private String name;
	private String username;
	private String password;
	private double rating;
	private int ratingCount;
	
	public User(int userID, String name, String username, String password,
			double rating, int ratingCount) {
		this.userID = userID;
		this.name = name;
		this.username = username;
		this.password = password;
		this.rating = rating;
		this.ratingCount = ratingCount;
	}

	public int getUserID() {
		return userID;
	}

	public String getName() {
		return name;
	}

	public String getUsername() {
		return username;
	}
	
	public String getPassword() {
		return password;
	}
	
	public double getRating() {
		return rating;
	}

	public int getRatingCount() {
		return ratingCount;
	}
}
