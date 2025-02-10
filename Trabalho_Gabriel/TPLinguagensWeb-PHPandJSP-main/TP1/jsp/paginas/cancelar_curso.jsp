<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<%
    
    // Verificar se o utilizador está autenticado e se é administrador ou se é docente
    if (session.getAttribute("perfil") == null || (!session.getAttribute("perfil").equals("admin") && !session.getAttribute("perfil").equals("docente"))) {
        response.sendRedirect("index.jsp");
    } else {

        PreparedStatement ps = null;
        
        String id_curso = request.getParameter("id_curso");
        String perfil = (String)session.getAttribute("perfil");

        String sql = "DELETE FROM inscricoes WHERE id_curso = " + id_curso;
        ps = conn.prepareStatement(sql);
        int rs = ps.executeUpdate(sql); 

        String sql2 = "DELETE FROM cursos WHERE id_curso = " + id_curso;
        ps = conn.prepareStatement(sql2);
        int rs2 = ps.executeUpdate(sql2);

        out.println("Curso cancelado com sucesso!<br>");
        switch (perfil) {
            case "docente":
                response.setHeader("Refresh", "3; URL=menu_docente.jsp");
                break;
            case "admin":
                response.setHeader("Refresh", "3; URL=cursos_admin.jsp");
                break;
        }
        
        
        
        ps.close();
        conn.close();

    }
    
%>