package cs201Project;

import java.sql.Blob;

public class Product {
	
	private int productID;
	private String productName;
	private double productPrice;
	private String productCondition;
	private String productDescription;
	private String productCategory;
	private int sellerID;
	private String sellerName;
	private Blob picture = null;
	
	public Product(int productID, String productName, double productPrice, String productCondition,
			String productDescription, String productCategory, int sellerID, String sellerName) {
		this.productID = productID;
		this.productName = productName;
		this.productPrice = productPrice;
		this.productCondition = productCondition;
		this.productDescription = productDescription;
		this.productCategory = productCategory;
		this.sellerID = sellerID;
		this.sellerName = sellerName;
	}

	public int getProductID() {
		return productID;
	}
	
	public String getProductName() {
		return productName;
	}

	public double getProductPrice() {
		return productPrice;
	}

	public String getProductCondition() {
		return productCondition;
	}

	public String getProductDescription() {
		return productDescription;
	}

	public String getProductCategory() {
		return productCategory;
	}

	public int getSellerID() {
		return sellerID;
	}
	public String getSellerName() {
		return sellerName;
	}
	public void setImage(Blob a) {
		picture = a;
	}
	public Blob getImage() {
		return picture;
	}
}
