

<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Perfil</title>
</head>
<body>
    
    <% 
    
        PreparedStatement ps = null;
        ResultSet rs = null;
        String id = session.getAttribute("id").toString();
        String user_name = null;
    
    
        if (id != null) {
            out.println("<a href='logout.jsp'>Logout</a>");
            String home_page_perfil = null;
            // considerando o perfil do utilizador encaminha para a páguna correspondente
            switch ((String) session.getAttribute("perfil")) {
                case "aluno":
                    home_page_perfil = "menu_aluno.jsp";
                    break;
                case "docente":
                    home_page_perfil = "menu_docente.jsp";
                    break;
                case "admin":
                    home_page_perfil = "menu_admin.jsp";
                    break;
            }
            out.println("<br><a href='" + home_page_perfil + "'>Home Page</a>");
            out.println("<br><h1>Editar dados pessoais</h1>");
            
            
            
            String sql = "SELECT * FROM utilizadores WHERE id_utilizador = ?";
            ps = conn.prepareStatement(sql);
            ps.setString(1, id);
            rs = ps.executeQuery();
            
            if (rs.next()) {
    %>
    <form action="atualizar_perfil.jsp" method="POST">
        <input type="hidden" name="id_utilizador" value="<%= id %>">
        Nome: <input type="text" name="nome" value="<%= rs.getString("nome") %>"><br>
        Último nome: <input type="text" name="ultimo_nome" value="<%= rs.getString("ultimo_nome") %>"><br>
        User name: <input type="text" name="user_name" value="<%= rs.getString("user_name") %>"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Atualizar">
    </form>
    <% 
            } else {
                out.println("Erro ao buscar dados do utilizador.");
            }
        } else {
            response.sendRedirect("index.jsp");
        }
    
    %>
</body>
</html>