<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<%
    
    PreparedStatement ps = null;
    ResultSet rs = null;
    
        
    if (session.getAttribute("perfil") != null && session.getAttribute("perfil").equals("admin")) {
        out.println("<a href='logout.jsp'>Logout<br></a>");
        out.println("<a href='menu_admin.jsp'>Home Page<br></a>");

        String sql = "SELECT * FROM utilizadores WHERE perfil = 'docente'";
        ps = conn.prepareStatement(sql);
        rs = ps.executeQuery();

        if (rs != null && rs.next()) {
            out.println("<h2>Lista de docentes:</h2>");
            out.println("<table border='1'>");
            out.println("<tr>");
            out.println("<th>ID</th>");
            out.println("<th>Nome</th>");
            out.println("<th>Último Nome</th>");
            out.println("<th>E-mail</th>");
            out.println("<th>User Name</th>");
            out.println("</tr>");

            do {
                out.println("<tr>");
                out.println("<td>" + rs.getString("id_utilizador") + "</td>");
                out.println("<td>" + rs.getString("nome") + "</td>");
                out.println("<td>" + rs.getString("ultimo_nome") + "</td>");
                out.println("<td>" + rs.getString("e_mail") + "</td>");
                out.println("<td>" + rs.getString("user_name") + "</td>");
                out.println("</tr>");
            } while (rs.next());

            out.println("</table>");
        } else {
            out.println("<h4>Ainda não há docentes<br></h4>");
        }

        out.println("<h2>Criar curso:</h2>");
        %>
        <form action="criar_curso.jsp" method="POST">
            Id do docente<input type="number" name="id"><br>
            Nome Curso: <input type="text" name="nome_curso"><br>
            Descrição: <textarea name="descricao" rows="1" cols="50"></textarea><br>
            Preço: <input type="number" name="preco"><br>
            Vagas: <input type="number" name="vagas_totais"><br>
            <input type="submit" value="Criar Curso">
        </form>
        <%
        String sqlCursos = "SELECT * FROM cursos";
        ps = conn.prepareStatement(sqlCursos);
        rs = ps.executeQuery();

        if (rs != null && rs.next()) {
            out.println("<h2>Todos os cursos:</h2>");
            out.println("<table border='1'>");
            out.println("<tr>");
            out.println("<th>Id_curso</th>");
            out.println("<th>ID docente</th>");
            out.println("<th>Título do curso</th>");
            out.println("<th>Descrição</th>");
            out.println("<th>Preço</th>");
            out.println("<th>Vagas Restantes</th>");
            out.println("<th>Inscritos</th>");
            out.println("<th>Vagas Totais</th>");
            out.println("<th>Ação</th>");
            out.println("</tr>");

            do {
                session.setAttribute("id_curso", rs.getString("id_curso"));
                out.println("<tr>");
                out.println("<td>" + rs.getString("id_curso") + "</td>");
                out.println("<td>" + rs.getString("id_utilizador") + "</td>");
                out.println("<td>" + rs.getString("nome_curso") + "</td>");
                out.println("<td>" + rs.getString("descricao") + "</td>");
                out.println("<td>" + rs.getString("preco") + "€</td>");
                out.println("<td>" + rs.getString("vagas_disponiveis") + "</td>");
                out.println("<td>" + (rs.getInt("vagas_totais") - rs.getInt("vagas_disponiveis")) + "</td>");
                out.println("<td>" + rs.getString("vagas_totais") + "</td>");
                out.println("<td><a href='gerenciar_curso.jsp?id_curso="+rs.getString("id_curso")+"'>Gestão</a></td>");
                out.println("</tr>");
            } while (rs.next());

            out.println("</table>");
        } else {
            out.println("<h4>Ainda não há cursos.<br></h4>");
        }
    } else {
        response.sendRedirect("index.jsp");
    }

    ps.close();
    rs.close();
    conn.close();

%>
