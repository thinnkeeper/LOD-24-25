<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin</title>
</head>
<body>

<%
	if (session.getAttribute("perfil") == null || !session.getAttribute("perfil").equals("admin")) {
		response.sendRedirect("index.jsp");
	}
%>

<a href="logout.jsp">Logout</a>
<h1>Bem-vindo <%= session.getAttribute("user_name") %></h1>
<h4> Você está na pagina do admin</h4><br><br>

<a href="editar_perfil.jsp">Editar Perfil<br></a>
<a href="cursos_admin.jsp">Cursos<br></a>

<div class="form-container">
        <h2>Registar Utilizador</h2>
        <form action="registo.jsp" method="post">
			<input type="hidden" name="isDocente" value="true"> <!-- forma para saber se é docente -->
            Nome: <input type="text" name="nome" style="margin-bottom: 10px;"><br>      
            Último nome: <input type="text" name="ultimo_nome"style="margin-bottom: 10px;"><br>      
            E-mail: <input type="text" name="e_mail"style="margin-bottom: 10px;"><br>
            User_name: <input type="text" name="user_name"style="margin-bottom: 10px;"><br>
            Password: <input type="password" name="password"style="margin-bottom: 10px;"><br>
            Perfil:
            <select name="perfil" style="margin-bottom: 10px;">
                <option value="aluno">Aluno</option>
                <option value="docente">Docente</option>
                <option value="admin">Administrador</option>
            </select><br>
            <input type="submit" value="Registar">
        </form>
    </div>

<%
	//query para achar os utilizadores que ainda nao foram autenticados
	String sql = "SELECT * FROM utilizadores WHERE autenticado = false";
	PreparedStatement ps = conn.prepareStatement(sql);
	ResultSet resultado = ps.executeQuery();

	if (resultado.next()) {
		out.println("<h2> Pedidos Pendentes </h2>");
		out.println("<table border='1'>");
		out.println("  <tr>");
		out.println("      <th>ID</th>");
		out.println("      <th>Nome</th>");
		out.println("      <th>Último Nome</th>");
		out.println("      <th>E-mail</th>");
		out.println("      <th>User Name</th>");
		out.println("      <th>Perfil</th>");
		out.println("      <th>Ação</th>");
		out.println("      <th>Ação</th>");

		out.println("  </tr>");

		do {
			out.println("  <tr>");
			out.println("      <td>" + resultado.getString("id_utilizador") + "</td>");
			out.println("      <td>" + resultado.getString("nome") + "</td>");
			out.println("      <td>" + resultado.getString("ultimo_nome") + "</td>");
			out.println("      <td>" + resultado.getString("e_mail") + "</td>");
			out.println("      <td>" + resultado.getString("user_name") + "</td>");
			out.println("      <td>" + resultado.getString("perfil") + "</td>");
			out.println("      <td><a href='autenticar_utilizador.jsp?id=" + resultado.getString("id_utilizador") + "&e_mail=" + resultado.getString("e_mail") + "&user_name=" + resultado.getString("user_name") + "'>Autenticar</a></td>");
			out.println("      <td><a href='confirmacao.jsp?id=" + resultado.getString("id_utilizador") + "&e_mail=" + resultado.getString("e_mail") + "&user_name=" + resultado.getString("user_name") + "'>Excluir utilizador</a></td>");
			out.println("  </tr>");
		} while (resultado.next());

		out.println("</table>");
	} else {
		out.println("<h4>Não há pedidos pendentes<br></h4>");
	}

	resultado.close();

	//query para pegar todos os utilizadores autenticados
	String autenticados = "SELECT * FROM utilizadores WHERE autenticado = true";
	PreparedStatement psAutenticados = conn.prepareStatement(autenticados);
	ResultSet resultadoAutenticados = psAutenticados.executeQuery();

	if (resultadoAutenticados.next()) {
		out.println("<h2> Utilizadores autenticados </h2>");
		out.println("<table border='1'>");
		out.println("  <tr>");
		out.println("      <th>ID</th>");
		out.println("      <th>Nome</th>");
		out.println("      <th>Último Nome</th>");
		out.println("      <th>E-mail</th>");
		out.println("      <th>User Name</th>");
		out.println("      <th>Perfil</th>");
		out.println("      <th>Ação</th>");
		out.println("      <th>Ação</th>");
		out.println("  </tr>");

		do {
			out.println("  <tr>");
			out.println("      <td>" + resultadoAutenticados.getString("id_utilizador") + "</td>");
			out.println("      <td>" + resultadoAutenticados.getString("nome") + "</td>");
			out.println("      <td>" + resultadoAutenticados.getString("ultimo_nome") + "</td>");
			out.println("      <td>" + resultadoAutenticados.getString("e_mail") + "</td>");
			out.println("      <td>" + resultadoAutenticados.getString("user_name") + "</td>");
			out.println("      <td>" + resultadoAutenticados.getString("perfil") + "</td>");
			out.println("      <td><a href='bloquear_utilizador.jsp?id=" + resultadoAutenticados.getString("id_utilizador") + "&e_mail=" + resultadoAutenticados.getString("e_mail") + "&user_name=" + resultadoAutenticados.getString("user_name") + "'>Bloquear acesso</a></td>");
			out.println("      <td><a href='confirmacao.jsp?id=" + resultadoAutenticados.getString("id_utilizador") + "&e_mail=" + resultadoAutenticados.getString("e_mail") + "&user_name=" + resultadoAutenticados.getString("user_name") + "'>Excluir utilizador</a></td>");
			out.println("  </tr>");
		} while (resultadoAutenticados.next());

		out.println("</table>");
	} else {
		out.println("<h4>Não há pedidos pendentes<br></h4>");
	}

	resultado.close();
	resultadoAutenticados.close();
	ps.close();	
	psAutenticados.close();
	conn.close();

%>

</body>
</html>
