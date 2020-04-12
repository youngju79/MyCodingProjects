

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

/**
 * Servlet implementation class WebServ
 */
@WebServlet("/WebServ")
public class WebServ extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public WebServ() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @throws IOException 
	 * @throws ServletException 
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
    protected void validate(PrintWriter write, String search, String type) {
    	//TYPE CHECK
    	if(type==null) {  //empty type
    		write.println("Need to choose type.");
    	}
    	else if(type.isEmpty()) {  //empty type
    		write.println("Need to choose type.");
    	}
    	//SEARCH CHECK
    	if(search.isEmpty()) {  //empty search bar
    		write.println("Need to fill in search bar.");
    	}
    	else if(search==null) {  //empty search bar
    		write.println("Need to fill in search bar.");
    	}
    }
	protected void service(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		String search = request.getParameter("search");
		String type = request.getParameter("type");
		PrintWriter write = response.getWriter();
		//check for errors
		validate(write, search, type);
		write.flush();
		write.close();
	}
}
