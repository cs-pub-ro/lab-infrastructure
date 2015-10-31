TEXFILES = texfiles
STY_DIR = sty
BASENAMES = sample-15 sample-20 sample-30 \
	    uso iocla rl so pr cpl so2 osp cns gsr scr sred saisp etm
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
