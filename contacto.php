<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuidar de Si - Contacte-nos para serviços de apoio domiciliário.">
    <title>Contacto - Cuidar de Si</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="navbar.css" rel="stylesheet">
    <link href="footer.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index">
                <img src="images/logo_cuidar_de_si.jpg" alt="Cuidar de Si" class="logo">
            </a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav main-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="index">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="servicos">
                            <i class="fas fa-hand-holding-medical"></i> Serviços
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contacto">
                            <i class="fas fa-envelope"></i> Contacto
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Contact Section -->
    <section class="contact-hero">
        <div class="container text-center">
            <h1>Pedido de orçamento</h1>
            <p>Preencha o formulário para solicitar um orçamento dos nossos serviços.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="contact-info-card">
                        <div class="contact-info-item">
                            <i class="fas fa-phone-alt"></i>
                            <div class="info-content">
                                <h5>Telefone</h5>
                                <p>223 711 700</p>
                            </div>
                        </div>
                        
                        <div class="contact-info-item">
                            <i class="fas fa-mobile-alt"></i>
                            <div class="info-content">
                                <h5>Telemóvel</h5>
                                <p>933 815 041</p>
                            </div>
                        </div>
                        
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <div class="info-content">
                                <h5>Email</h5>
                                <p>geral@cuidardesi.pt</p>
                            </div>
                        </div>
                        
                        <div class="contact-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="info-content">
                                <h5>Morada</h5>
                                <p>Av. da República 676, 4430-190<br>Vila Nova de Gaia</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="contact-form">
                        <?php if (isset($_GET['contact_status'])): ?>
                            <?php if ($_GET['contact_status'] === 'success'): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <?php 
                                    if (isset($_GET['msg'])) {
                                        echo htmlspecialchars(urldecode($_GET['msg']));
                                    } else {
                                        echo "Mensagem enviada com sucesso! Entraremos em contato em breve.";
                                    }
                                    ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php elseif ($_GET['contact_status'] === 'error'): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <?php 
                                    if (isset($_GET['msg'])) {
                                        echo htmlspecialchars(urldecode($_GET['msg']));
                                    } else {
                                        echo "Ocorreu um erro ao enviar a mensagem. Por favor, tente novamente.";
                                    }
                                    ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <form action="processar_contato.php" method="post" class="needs-validation" novalidate id="contactForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control" id="name" name="name" required minlength="2" maxlength="100">
                                <div class="invalid-feedback">
                                    Por favor, insira o seu nome completo.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                                <div class="invalid-feedback">
                                    Por favor, insira um endereço de email válido.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefone *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required pattern="[0-9+\s\-\(\)]{9,15}">
                                <div class="invalid-feedback">
                                    Por favor, insira um número de telefone válido.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Mensagem *</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required minlength="10" maxlength="1000"></textarea>
                                <div class="invalid-feedback">
                                    Por favor, insira uma mensagem (mínimo 10 caracteres).
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i>Enviar Mensagem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <div class="container">
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3004.8876812325087!2d-8.6067873!3d41.1274289!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd2465e01239c799%3A0x4a59df82c0b4e0ee!2sAv.%20da%20Rep%C3%BAblica%20676%2C%204430-190%20Vila%20Nova%20de%20Gaia!5e0!3m2!1spt-PT!2spt!4v1710951001774!5m2!1spt-PT!2spt"
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>

    <!-- Work With Us Section -->
    <div class="container">
        <div class="work-with-us-section">
            <h3>
                <i class="fas fa-briefcase me-2"></i>Trabalhe Connosco
            </h3>
            <p>Junte-se à nossa equipa de profissionais dedicados e faça a diferença na vida de quem mais precisa.</p>
            
            <?php if (isset($_GET['status'])): ?>
                <?php if ($_GET['status'] === 'success'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>Candidatura enviada com sucesso! Entraremos em contacto em breve.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif ($_GET['status'] === 'error'): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php 
                        if (isset($_GET['msg'])) {
                            echo htmlspecialchars(urldecode($_GET['msg']));
                        } else {
                            echo "Ocorreu um erro ao enviar a candidatura. Por favor, tente novamente.";
                        }
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <form action="enviar_email.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate id="candidaturaForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nome_candidato" class="form-label">Nome Completo *</label>
                        <input type="text" class="form-control" id="nome_candidato" name="nome" required minlength="2" maxlength="100">
                        <div class="invalid-feedback">
                            Por favor, insira o seu nome completo.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="telefone_candidato" class="form-label">Telefone *</label>
                        <input type="tel" class="form-control" id="telefone_candidato" name="telefone" required pattern="[0-9+\s\-\(\)]{9,15}">
                        <div class="invalid-feedback">
                            Por favor, insira um número de telefone válido.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="email_candidato" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email_candidato" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                        <div class="invalid-feedback">
                            Por favor, insira um endereço de email válido.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="curriculo" class="form-label">Curriculum Vitae</label>
                        <input type="file" class="form-control" id="curriculo" name="curriculo" accept=".pdf,.doc,.docx">
                        <div class="form-text">Formatos aceites: PDF, DOC, DOCX (máximo 5MB)</div>
                        <div class="invalid-feedback">
                            Por favor, selecione um arquivo válido.
                        </div>
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary" id="submitCandidaturaBtn">
                            <i class="fas fa-upload me-2"></i>Enviar Candidatura
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark text-light py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <!-- Primeira coluna -->
                <div class="col-md-4 mb-4">
                    <h5>Cuidar de Si</h5>
                    <p>Cuidamos de quem mais importa para si, com dedicação e profissionalismo.</p>
                </div>

                <!-- Segunda coluna -->
                <div class="col-md-4 mb-4">
                    <h5>Links Úteis</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="https://livroreclamacoes.pt" class="text-light text-decoration-none">
                                <i class="fas fa-book me-2"></i>Livro de Reclamações
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="mt-4">

            <div class="text-center py-3">
                <small>&copy; 2025 Cuidar de Si. Todos os direitos reservados.</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>

    <!-- WhatsApp Floating Button -->
    <div class="whatsapp-float">
        <a href="https://wa.me/351933815041" target="_blank" rel="noopener noreferrer">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
</body>
</html> 