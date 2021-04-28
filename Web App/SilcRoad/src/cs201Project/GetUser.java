package cs201Project;


import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 * Servlet implementation class GetUser
 */
@WebServlet("/GetUser")
public class GetUser extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public GetUser() {
        super();
        // TODO Auto-generated constructor stub
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
    
	protected void service(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		int userID = Integer.parseInt(request.getParameter("userID"));
		request.setAttribute("userID", userID);
		String path = "jdbc:mysql://google/silcData?cloudSqlInstance=cs201silcproject:us-west1:cs201group"
				+ "&socketFactory=com.google.cloud.sql.mysql.SocketFactory&useSSL=false&user=yongzush";
		Connection conn = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		try {
			Class.forName("com.mysql.jdbc.Driver");
			conn = DriverManager.getConnection(path);
			ps = conn.prepareStatement("SELECT * FROM User WHERE userID=?");
			ps.setInt(1, userID);
			rs = ps.executeQuery();
			while(rs.next()) { 
				request.setAttribute("name", rs.getString(2));
				request.setAttribute("email", rs.getString(5));
				request.setAttribute("rating", rs.getDouble(6));
			}
		}
		catch(Exception e) {
			e.printStackTrace();
		}
		close_conn(conn, ps, rs);
		RequestDispatcher req = getServletContext().getRequestDispatcher("/UserProfile.jsp");
		req.forward(request, response);
	}
}
