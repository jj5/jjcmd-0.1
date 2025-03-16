#!/bin/bash

# 2025-03-17 jj5 - source this file from your bashrc script to get the interactive environment.

JJCMD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )/.." && realpath . )";
JJCMD_DIR_BIN="$JJCMD_DIR/bin";
#JJCMD_DIR_ETC="$JJCMD_DIR/etc";
JJCMD_DIR_INC="$JJCMD_DIR/inc";
JJCMD_DIR_SRC="$JJCMD_DIR/src";

[ -d "$JJCMD_DIR_BIN" ] || { echo "error: JJCMD_DIR_BIN not found: $JJCMD_DIR_BIN"; exit 40; }
#[ -d "$JJCMD_DIR_ETC" ] || { echo "error: JJCMD_DIR_ETC not found: $JJCMD_DIR_ETC"; exit 40; }
[ -d "$JJCMD_DIR_INC" ] || { echo "error: JJCMD_DIR_INC not found: $JJCMD_DIR_INC"; exit 40; }
[ -d "$JJCMD_DIR_SRC" ] || { echo "error: JJCMD_DIR_SRC not found: $JJCMD_DIR_SRC"; exit 40; }

source "$JJCMD_DIR_BIN/shell/jjcmd-lib.sh";
