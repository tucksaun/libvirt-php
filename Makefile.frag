.PHONY: doc
doc:
	$(CC) $(CFLAGS) -Wall -o $(TOOLS_DIR)/generate-api-docs $(TOOLS_DIR)/generate-api-docs.c
	./$(TOOLS_DIR)/generate-api-docs $(top_srcdir)/src/libvirt-php.c $(top_builddir)/$(DOC_DIR)/api-reference.html.in
	./$(TOOLS_DIR)/generate-api-docs --private $(top_srcdir)/src/libvirt-php.c $(top_builddir)/$(DOC_DIR)/dev-api-reference.html.in
