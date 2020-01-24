package cs201Project;


import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 * Servlet implementation class CheckRequest
 */
@WebServlet("/CheckRequest")
public class CheckRequest extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public CheckRequest() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
    
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
    
	protected void service(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		int buyerID = Integer.parseInt(request.getParameter("buyerID"));
		int productID = Integer.parseInt(request.getParameter("productID"));
		PrintWriter write = response.getWriter();
		boolean exists = false;
		String path = "jdbc:mysql://google/silcData?cloudSqlInstance=cs201silcproject:us-west1:cs201group"
				+ "&socketFactory=com.google.cloud.sql.mysql.SocketFactory&useSSL=false&user=yongzush";
		Connection conn = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		try {
			Class.forName("com.mysql.jdbc.Driver");
			conn = DriverManager.getConnection(path);
			ps = conn.prepareStatement("SELECT * FROM Transactions WHERE buyerID=?" + 
				" AND productID=?");
			ps.setInt(1, buyerID);
			ps.setInt(2, productID);
			rs = ps.executeQuery();
			while(rs.next()) { 
				exists = true;
			}
		}
		catch(Exception e) {
			e.printStackTrace();
		}
		if(exists) {  //already exists
			write.println("Already exists");
		}
		write.flush();
		write.close();
		close_conn(conn, ps, rs);
	}
}
