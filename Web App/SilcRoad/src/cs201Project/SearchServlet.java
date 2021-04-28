package cs201Project;
import java.io.IOException;
import java.io.InputStream;
import java.net.URL;
import java.sql.DriverManager;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;
import java.util.Iterator;
import java.sql.Blob;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.PreparedStatement;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

//public class aToZSort() implements Comparator<Product> {
//	@Override
//	public int compare(Product p1, Product p2) {
//		return p1.getProductName().compareTo(p2.getProductName());
//	}
//}

/**
 * Servlet implementation class SearchServlet
 */
@WebServlet("/SearchServlet")
public class SearchServlet extends HttpServlet {
	private static final long serialVersionUID = 1L;
	
	protected void service(HttpServletRequest request, HttpServletResponse response) 
			throws ServletException, IOException {
		
		// Preset radio buttons and dropdown menus to unchecked
		request.setAttribute("hightolowSelected", "");
		request.setAttribute("lowtohighSelected", "");
		request.setAttribute("atozselected", "");
		request.setAttribute("ztoaselected", "");
		
		request.setAttribute("booksChecked", "");
		request.setAttribute("furnitureChecked", "");
		request.setAttribute("ticketsChecked", "");
		request.setAttribute("clothingChecked", "");
		request.setAttribute("housingChecked", "");
		request.setAttribute("miscChecked", "");
		
		// Will forward to search results page by default
		String next = "/search.jsp";
		RequestDispatcher dispatch = getServletContext().getRequestDispatcher(next);
		
		// Get search query
		String query = request.getParameter("searchInput");
		request.setAttribute("searchInput", query);
		
		System.out.println("Search input: " + query);
				
		// Check if search query is empty
		if(query.trim().equalsIgnoreCase("")) {
			next = "/homepage.jsp";
			// Set error message
			request.setAttribute("searchError", "You must enter search keywords!");
			dispatch = getServletContext().getRequestDispatcher(next);
			dispatch.forward(request, response);
		}
		
		// If the search query is not empty, split it into separate strings
		String[] keywords = query.split(" ");
		
		// Create HashMap to store results
		HashMap<Integer, Product> resultsMap = new HashMap<Integer, Product>();
		
		// Iterate over search keywords
		Connection conn = null;
		PreparedStatement ps = null;
		ResultSet rs = null;
		int count = 0;
		
		for(int i = 0; i < keywords.length; i++) {
			String searchString = "SELECT * FROM Product WHERE productName LIKE ?";
			try {
				Class.forName("com.mysql.jdbc.Driver");
				conn = DriverManager.getConnection("jdbc:mysql://google/silcData?cloudSqlInstance=cs201silcproject:us-west1:cs201group&socketFactory=com.google.cloud.sql.mysql.SocketFactory&useSSL=false&user=woody&password=woody");
				// Search for entry
				ps = conn.prepareStatement(searchString);
				ps.setString(1, '%' + keywords[i] + '%');
				rs = ps.executeQuery();
				
				while(rs.next()) {
					count++;
					// Get product information
					int productID = rs.getInt("productID");
					String productName = rs.getString("productName");
					double productPrice = rs.getDouble("productPrice");
					String productCondition = rs.getString("productCondition");
					String productDescription = rs.getString("productDescription");
					String productCategory = rs.getString("productCategory");
					int sellerID = rs.getInt("sellerID");
					String sellerName = rs.getString("sellerName");
					Blob holder = rs.getBlob("image");
					// Create new Project object
					Product newProduct = new Product(productID, productName, productPrice, productCondition, productDescription, productCategory, sellerID, sellerName);
					if(holder!=null) {
						newProduct.setImage(holder);
					}
					// Insert search result into the results HashMap
					resultsMap.put(productID, newProduct);
				}
			} catch (Exception e) {
				e.printStackTrace();
			} finally {
				// Close connections
				try {
					if (rs != null) {
						rs.close();
					}
					if (ps != null) {
						ps.close();
					}
					if (conn != null) {
						conn.close();
					}
				} catch (SQLException sqle) {
					System.out.println("sqle: " + sqle.getMessage());
				}
			}
		}
		System.out.println("the amount object in database with that name: "+ count);
		
		String sortName = request.getParameter("sortName");
		String sortPrice = request.getParameter("sortPrice");
		String sortCategory = request.getParameter("sortCategory");
		
		System.out.println("sortPrice = " + sortPrice);
		
		// Convert map to ArrayList
		ArrayList<Product> resultsList = new ArrayList<Product>(resultsMap.values());
		
		if(sortName != null && sortName.equalsIgnoreCase("aToZ")) {
			// Sort list alphabetically A to Z
			Collections.sort(resultsList, new Comparator<Product>() {
				@Override
				public int compare(Product p1, Product p2) {
					return p1.getProductName().compareToIgnoreCase(p2.getProductName());
				}
			});
			request.setAttribute("atozSelected", "selected");
		}
		else if(sortName != null && sortName.equalsIgnoreCase("zToA")) {
			// Sort list reverse alphabetically
			Collections.sort(resultsList, new Comparator<Product>() {
				@Override
				public int compare(Product p1, Product p2) {
					return p2.getProductName().compareToIgnoreCase(p1.getProductName());
				}
			});
			request.setAttribute("ztoaSelected", "selected");
		}
		
		if(sortPrice != null && sortPrice.equalsIgnoreCase("lowToHigh")) {
			// Sort list by increasing price
			System.out.println("sorting by increasing price");
			Collections.sort(resultsList, new Comparator<Product>() {
				@Override
				public int compare(Product p1, Product p2) {
					if(p1.getProductPrice() > p2.getProductPrice()) return 1;
					else if(p1.getProductPrice() < p2.getProductPrice()) return -1;
					else return 0;
				}
			});
			request.setAttribute("lowtohighSelected", "selected");
		}
		else if(sortPrice != null && sortPrice.equalsIgnoreCase("highToLow")) {
			// Sort list by decreasing price
			Collections.sort(resultsList, new Comparator<Product>() {
				@Override
				public int compare(Product p1, Product p2) {
					if(p1.getProductPrice() < (p2.getProductPrice())) return 1;
					else if(p1.getProductPrice() > p2.getProductPrice()) return -1;
					else return 0;
				}
			});
			request.setAttribute("hightolowSelected", "selected");
		}
		
		// Filter based on category
		System.out.println("Total hits: " + resultsList.size());
		if(sortCategory != null) {
			System.out.println("Category: " + sortCategory);
			
			Iterator<Product> it = resultsList.iterator();
			while(it.hasNext()) {
				Product p = it.next();
				if(!p.getProductCategory().equalsIgnoreCase(sortCategory)) {
					it.remove();
				}
			}
			
			if(sortCategory.equalsIgnoreCase("books")) {
				request.setAttribute("booksChecked", "checked");
			}
			else if(sortCategory.equalsIgnoreCase("furniture")) {
				request.setAttribute("furnitureChecked", "checked");
			}
			else if(sortCategory.equalsIgnoreCase("tickets")) {
				request.setAttribute("ticketsChecked", "checked");
			}
			else if(sortCategory.equalsIgnoreCase("clothing")) {
				request.setAttribute("clothingChecked", "checked");
			}
			else if(sortCategory.equalsIgnoreCase("housing")) {
				request.setAttribute("housingChecked", "checked");
			}
			else if(sortCategory.equalsIgnoreCase("misc")) {
				request.setAttribute("miscChecked", "checked");
			}
		}
		
		// Set results attribute
		request.setAttribute("resultList", resultsList);
		
		System.out.println("New order:");
		for(int i = 0;i < resultsList.size(); i++ ) {
			System.out.println(resultsList.get(i).getProductName());
		}
		
		System.out.println("Forwarding to results page");
		// Forward to results page
		dispatch = getServletContext().getRequestDispatcher(next);
		dispatch.forward(request, response);
		
	}
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public SearchServlet() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		response.getWriter().append("Served at: ").append(request.getContextPath());
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		doGet(request, response);
	}

}
