<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Docente</title>
</head>
<body>
<%
	

	int id_utilizador =(int) session.getAttribute("id");
	String perfil = (String) session.getAttribute("perfil");
	String user_name = (String) session.getAttribute("user_name");
	
	if (perfil != null && perfil.equals("docente")) {
%>
	<a href="logout.jsp">Logout</a>
	<h1>Bem-vindo <%= user_name %></h1>
	<h4>Você está na página do docente</h4><br><br>
	<a href="editar_perfil.jsp">Editar Perfil</a>

<%
		
		PreparedStatement ps = null;
		ResultSet rs = null;

		String sql = "SELECT * FROM cursos WHERE id_utilizador = " + id_utilizador;
		ps = conn.prepareStatement(sql);
		rs = ps.executeQuery();

		if (rs.next()) {
%>
		<h2>Teus cursos:</h2>
		<table border="1">
			<tr>
				<th>Id_curso</th>
				<th>Título do curso</th>
				<th>Descrição</th>
				<th>Preço</th>
				<th>Vagas Restantes</th>
				<th>Inscritos</th>
				<th>Vagas Totais</th>
				<th>Ação</th>
			</tr>
<%
			do {
%>
				<tr>
					<td><%= rs.getInt("id_curso") %></td>
					<td><%= rs.getString("nome_curso") %></td>
					<td><%= rs.getString("descricao") %></td>
					<td><%= rs.getInt("preco") %></td>
					<td><%= rs.getInt("vagas_disponiveis") %></td>
					<td><%= rs.getInt("vagas_totais") - rs.getInt("vagas_disponiveis") %></td>
					<td><%= rs.getInt("vagas_totais") %></td>
					<td><a href="gerenciar_curso.jsp?id_curso=<%= rs.getInt("id_curso") %>">Gestão</a></td>
				</tr>
<%
			} while (rs.next());
%>
		</table>
<%
		} else {
			out.println("Ainda não leciona nenhum curso");
		}
%>


	<h2>Criar curso:</h2>
	<form action="criar_curso.jsp" method="POST">
		<input type="hidden" name="id" value="<%= id_utilizador %>">
		Nome Curso: <input type="text" name="nome_curso"><br>
		Descrição: <textarea name="descricao" rows="1" cols="50"></textarea><br>
		Preço: <input type="number" name="preco"><br>
		Vagas: <input type="number" name="vagas_totais"><br>
		<input type="submit" value="Criar Curso">
	</form>
<%
	} else {
		out.println("Problemas com autenticação");
		response.setHeader("Refresh", "3;url=index.jsp");
	}
%>
</body>
</html>
