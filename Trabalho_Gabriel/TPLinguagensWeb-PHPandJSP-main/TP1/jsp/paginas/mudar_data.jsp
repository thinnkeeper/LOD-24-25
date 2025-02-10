<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>
<%
    
    //verificar se o utilizador é admin ou docente
    if (session.getAttribute("perfil") == null || (!session.getAttribute("perfil").equals("admin") && !session.getAttribute("perfil").equals("docente"))) {
        response.sendRedirect("index.jsp");
    } else {

        PreparedStatement ps = null;
        ResultSet rs = null;

        String id_inscricao = request.getParameter("id_inscricao");

        String sql = "UPDATE inscricoes SET data_inscricao = CURRENT_TIMESTAMP WHERE id_inscricao = " + id_inscricao;

        ps = conn.prepareStatement(sql);

        int rowsAffected = ps.executeUpdate();

        if (rowsAffected > 0) {
            out.println("Mudança realizada com sucesso!<br>");
            response.setHeader("Refresh", "3; URL=gerenciar_curso.jsp?id_curso=" + request.getParameter("id_curso"));
        } else {
            out.println("Houve um problema com a inserção na base de dados");
        }
    }
%>