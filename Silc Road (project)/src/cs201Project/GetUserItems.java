package cs201Project;

import java.sql.Blob;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;

public class GetUserItems {
	public ArrayList<Product> getItems(int id){
		String path = "jdbc:mysql://google/silcData?cloudSqlInstance=cs201silcproject:us-west1:cs201group"
				+ "&socketFactory=com.google.cloud.sql.mysql.SocketFactory&useSSL=false&user=yongzush";
		Connection conn = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		ArrayList<Product> array = new ArrayList<Product>();
		try {
			Class.forName("com.mysql.jdbc.Driver");
			conn = DriverManager.getConnection(path);
			ps = conn.prepareStatement("SELECT * FROM Product WHERE sellerID=?");
			ps.setInt(1, id);
			rs = ps.executeQuery();
			while(rs.next()) { 
				int productID = rs.getInt(1);
				String productName = rs.getString(2);
				double productPrice = rs.getDouble(3);
				String productCondition = rs.getString(4);
				String productDescription = rs.getString(5);
				String productCategory = rs.getString(6);
				int sellerID = rs.getInt(7);
				String sellerName = rs.getString(8);
				Blob holder = rs.getBlob("image");
				Product temp = new Product(productID, productName, productPrice, productCondition,
						productDescription, productCategory, sellerID, sellerName);
				if(holder!=null) {
					temp.setImage(holder);
				}
				array.add(temp);
			}
		}
		catch(Exception e) {
			e.printStackTrace();
		}
		close_conn(conn, ps, rs);
		return array;
	}
	protected void close_conn(Connection conn, Statement st, ResultSet rs) {
		try {
			if(conn!=null) {
				conn.close();
			}
			if(st!=null) {
				st.close();
			}
			if(rs!=null) {
				rs.close();
			}
		}
		catch(SQLException sqle) {
			System.out.println(sqle.getMessage());
		}
	}
}
