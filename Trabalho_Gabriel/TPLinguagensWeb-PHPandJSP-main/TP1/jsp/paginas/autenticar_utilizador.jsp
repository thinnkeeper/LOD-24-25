<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<%
	
	// Verificar se o utilizador está autenticado e se é administrador 
	if (session.getAttribute("perfil") == null || !session.getAttribute("perfil").equals("admin")) {
		
		if (session.getAttribute("perfil") == "aluno"){

			response.sendRedirect("menu_aluno.jsp");
		} else if (session.getAttribute("perfil")=="docente") {

			response.sendRedirect("menu_docente.jsp");
		} else {
			
			response.sendRedirect("index.jsp");

		}
		
	} else {

		PreparedStatement ps = null;
		ResultSet rs = null;

		String id_utilizador = request.getParameter("id");
		String email_utilizador = request.getParameter("e_mail");
		String user_name = request.getParameter("user_name");

		String sql = "UPDATE utilizadores SET autenticado = 1 WHERE id_utilizador = ?";

		ps = conn.prepareStatement(sql);
		ps.setString(1, id_utilizador);

		int rowsAffected = ps.executeUpdate();

		if (rowsAffected > 0) {
			out.println("Utilizador com id=" + id_utilizador + ", user_name=" + user_name + " e e-mail=" + email_utilizador + " Foi autenticado com sucesso !!<br>");
			out.println("<a href='menu_admin.jsp'>Voltar para página admin</a>");
			response.setHeader("Refresh", "3; URL=menu_admin.jsp");
		}

		ps.close();
		conn.close();

	}
	

%>