<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>

<%
    
    //verificar se o utilizador está autenticado e se é administrador ou docente
    if (session.getAttribute("perfil") == null || (!session.getAttribute("perfil").equals("admin") && !session.getAttribute("perfil").equals("docente"))) {
        response.sendRedirect("index.jsp");
    } else {

        PreparedStatement ps = null;
        //ResultSet rs = null;
        
        
        String id_utilizador = request.getParameter("id");
        String nome_curso = request.getParameter("nome_curso");
        String descricao = request.getParameter("descricao");
        double preco = Double.parseDouble(request.getParameter("preco"));
        int vagas_totais = Integer.parseInt(request.getParameter("vagas_totais"));
        
        String tipo_perfil = (String) session.getAttribute("perfil");
        
        if (nome_curso.isEmpty() || descricao.isEmpty() || preco == 0 || vagas_totais == 0) {
            out.println("Não podem existir valores vazios, verifique !");
            
            if (tipo_perfil.equals("docente")) {
                response.setHeader("Refresh", "3; URL=menu_docente.jsp");
            } else {
                response.setHeader("Refresh", "3; URL=cursos_admin.jsp");
            }
        } else {
            String sql = "INSERT INTO cursos (id_utilizador, nome_curso, descricao, preco, vagas_disponiveis, vagas_totais) VALUES (?, ?, ?, ?, ?, ?)";

            ps = conn.prepareStatement(sql);
            ps.setString(1, id_utilizador);
            ps.setString(2, nome_curso);
            ps.setString(3, descricao);
            ps.setDouble(4, preco);
            ps.setInt(5, vagas_totais);
            ps.setInt(6, vagas_totais);
            
            int rowsAffected = ps.executeUpdate();
            
            if (rowsAffected > 0) {
                out.println("Curso " + nome_curso + " criado com sucesso!<br>");
                
                if (tipo_perfil.equals("docente")) {
                    out.println("<br><a href='menu_docente.jsp'>Home Page</a>");
                    response.setHeader("Refresh", "3; URL=menu_docente.jsp");
                } else {
                    out.println("<br><a href='menu_admin.jsp'>Home Page</a>");
                    response.setHeader("Refresh", "3; URL=cursos_admin.jsp");
                }
            }
        }

        conn.close();
        ps.close();
  }      
%>