package cs201Project;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.TreeMap;

public class Database {
	
	public static List<Transaction> getSellingTransactions(int sellerID) {
		Connection conn = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		
		String productSearch = "SELECT * FROM Product WHERE sellerID = ?";
		String transactionSearch = "SELECT * FROM Transactions WHERE sellerID = ? AND productID = ?";
		String buyerSearch = "SELECT Name FROM User WHERE userID = ?";
		
		List<Transaction> output = new ArrayList<Transaction>();
		
		try {
			Class.forName("com.mysql.jdbc.Driver");
			conn = DriverManager.getConnection("jdbc:mysql://google/silcData?"
					+ "cloudSqlInstance=cs201silcproject:us-west1:cs201group&socketFactory=com.google.cloud.sql.mysql.SocketFactory"
					+ "&useSSL=false&user=woody&password=woody");
			ps = conn.prepareStatement(productSearch);
			ps.setInt(1, sellerID);
			rs = ps.executeQuery();
			
			while(rs.next()) {
				
				int productID = rs.getInt(1);
				String productName = rs.getString(2);
				double price = rs.getDouble(3);
				
				Map<Integer,String> buyers = new TreeMap<Integer,String>();
				
				ps = conn.prepareStatement(transactionSearch);
				ps.setInt(1, sellerID);
				ps.setInt(2, productID);
				ResultSet transactions = ps.executeQuery();
				
				while(transactions.next()) {
					int buyerID = transactions.getInt(4);
					ps = conn.prepareStatement(buyerSearch);
					ps.setInt(1, buyerID);
					ResultSet buyer = ps.executeQuery();
					buyer.next();
					String buyerName = buyer.getString(1);
					buyers.put(buyerID, buyerName);
				}
				
				output.add(new Transaction(productID, productName, price, buyers));
			}
			
			rs.close();
			ps.close();
			conn.close();
			
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch(ClassNotFoundException e) {
			e.printStackTrace();
		}
		return output;
	}
	
	public static List<Transaction> getBuyingTransactions(int buyerID) {
		Connection conn = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		
		String transactionSearch = "SELECT * FROM Transactions WHERE buyerID = ?";
		String productSearch = "SELECT productName, productPrice FROM Product WHERE productID = ?";
		String sellerSearch = "SELECT Name FROM User WHERE userID = ?";
		
		List<Transaction> output = new ArrayList<Transaction>();
		
		try {
			conn = DriverManager.getConnection("jdbc:mysql://google/silcData?"
					+ "cloudSqlInstance=cs201silcproject:us-west1:cs201group&socketFactory=com.google.cloud.sql.mysql.SocketFactory"
					+ "&useSSL=false&user=maxwell&password=0000");
			ps = conn.prepareStatement(transactionSearch);
			ps.setInt(1, buyerID);
			rs = ps.executeQuery();
			
			while(rs.next()) {
				
				int productID = rs.getInt(2);
				int sellerID = rs.getInt(3);
				String productName = "";
				double price = 0;
				
				Map<Integer,String> buyers = new TreeMap<Integer,String>();
				
				ResultSet search = null;
				
				ps = conn.prepareStatement(productSearch);
				ps.setInt(1, productID);
				search = ps.executeQuery();
				
				if(search.next()) {
					productName = search.getString(1);
					price = search.getDouble(2);
				}
				
				ps = conn.prepareStatement(sellerSearch);
				ps.setInt(1, sellerID);
				search = ps.executeQuery();
				
				if(search.next()) {
					buyers.put(sellerID, search.getString(1));
				}
				
				output.add(new Transaction(productID, productName, price, buyers));
			}
			
			rs.close();
			ps.close();
			conn.close();
			
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return output;
	}
	
	public static boolean acceptTransaction(int productID) {
		
		Connection conn = null;
		PreparedStatement ps = null;
		
		String deleteTransaction = "DELETE FROM Transactions WHERE productID = ?";
		String deleteProduct = "DELETE FROM Product WHERE productID = ?";
		
		try {
			conn = DriverManager.getConnection("jdbc:mysql://google/silcData?"
						+ "cloudSqlInstance=cs201silcproject:us-west1:cs201group&socketFactory=com.google.cloud.sql.mysql.SocketFactory"
						+ "&useSSL=false&user=maxwell&password=0000");
			
			ps = conn.prepareStatement(deleteTransaction);
			ps.setInt(1, productID);
			
			if(ps.executeUpdate()==0) {
				return false;
			}
			
			ps = conn.prepareStatement(deleteProduct);
			ps.setInt(1, productID);
			
			if(ps.executeUpdate()==0) {
				return false;
			}
			
			return true;
			
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return false;
	}
	
	public static boolean rejectTransaction(int productID, int buyerID) {
		
		Connection conn = null;
		PreparedStatement ps = null;
		
		String deleteTransaction = "DELETE FROM Transactions WHERE productID = ? AND buyerID = ?";
		
		try {
			conn = DriverManager.getConnection("jdbc:mysql://google/silcData?"
						+ "cloudSqlInstance=cs201silcproject:us-west1:cs201group&socketFactory=com.google.cloud.sql.mysql.SocketFactory"
						+ "&useSSL=false&user=maxwell&password=0000");
			
			ps = conn.prepareStatement(deleteTransaction);
			ps.setInt(1, productID);
			ps.setInt(2, buyerID);
			
			if(ps.executeUpdate()==0) {
				return false;
			}
			return true;
			
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return false;
	}
	
	public static void addRating(int buyerID, int rating) {
		
		Connection conn = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		
		String searchRating = "SELECT rating, ratingCount FROM User WHERE userID = ?";
		String updateRating = "UPDATE User SET rating = ?, ratingCount = ? WHERE userID = ?";
		
		try {
			conn = DriverManager.getConnection("jdbc:mysql://google/silcData?"
						+ "cloudSqlInstance=cs201silcproject:us-west1:cs201group&socketFactory=com.google.cloud.sql.mysql.SocketFactory"
						+ "&useSSL=false&user=maxwell&password=0000");
			
			ps = conn.prepareStatement(searchRating);
			ps.setInt(1, buyerID);
			rs = ps.executeQuery();
			
			rs.next();
			
			double currRating = rs.getDouble(1);
			int ratingCount = rs.getInt(2);
			
			currRating = (currRating+rating)/(++ratingCount);
			
			ps = conn.prepareStatement(updateRating);
			ps.setDouble(1, currRating);
			ps.setInt(2, ratingCount);
			ps.setInt(3, buyerID);
			ps.executeUpdate();
			
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	
}
