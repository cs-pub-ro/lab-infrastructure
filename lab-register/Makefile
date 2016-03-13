TEXFILES = texfiles
STY_DIR = sty
BASENAMES = generic-15 generic-20 generic-30 \
	    uso iocla rl so pr pp cpl so2 osp cns gsr scr sred saisp etm \
	    asc app mps
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
