doc:
    cd "$(top_srcdir)/$(TOOLS_DIR)"
    $(CC) -Wall -o generate-api-docs generate-api-docs.c
    ./generate-api-docs $(top_srcdir)/$src/libvirt-php.c $(top_srcdir)/$(DOC_DIR)/api-reference.html.in
    ./generate-api-docs --private $(top_srcdir)/$src/libvirt-php.c $(top_srcdir)/$(DOC_DIR)/dev-api-reference.html.in
