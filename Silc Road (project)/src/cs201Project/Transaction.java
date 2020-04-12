package cs201Project;

import java.util.Map;

public class Transaction {
	private int productID;
	private String productName;
	private double price;
	private Map<Integer, String> users;
	
	
	public Transaction(int productID, String productName, double price, Map<Integer, String> user) {
		super();
		this.productID = productID;
		this.productName = productName;
		this.price = price;
		this.users = user;
	}


	public int getProductID() {
		return productID;
	}

	public String getProductName() {
		return productName;
	}


	public double getPrice() {
		return price;
	}


	public Map<Integer, String> getUser() {
		return users;
	}
}
