TEXFILES = texfiles
STY_DIR = sty
BASENAMES = sample
PDFFILES = $(addsuffix .pdf,$(BASENAMES))
CLASSFILE = $(STY_DIR)/register.cls

.PHONY: all clean

all: $(PDFFILES)

%.pdf: %.tex $(CLASSFILE)
	-mkdir $(TEXFILES)
	TEXINPUTS=$(STY_DIR)//: pdflatex -output-directory $(TEXFILES) $<
	TEXINPUTS=$(STY_DIR)//: pdflatex -output-directory $(TEXFILES) $<
	-ln -f $(TEXFILES)/$@ .

clean:
	-rm -rf $(TEXFILES) $(PDFFILES)
