#!/bin/bash

# filevault_status_controller
FV_CTL="${BASEURL}index.php?/module/filevault_status/"

# Create /usr/local/bin if missing
mkdir -p "${INSTALLROOT}/usr/local/bin" || ERR=1

# Get the scripts in the proper directories
${CURL}  "${FV_CTL}get_script/filevault_2_status_check.sh" -o "${INSTALLROOT}/usr/local/bin/filevault_2_status_check.sh" \
	&& ${CURL}  "${FV_CTL}get_script/filevaultstatus" -o "${MUNKIPATH}preflight.d/filevaultstatus" \

# Check exit status of curl
if [ $? = 0 ]; then
	# Make scripts executable
	chmod a+x "${INSTALLROOT}/usr/local/bin/filevault_2_status_check.sh" "${MUNKIPATH}preflight.d/filevaultstatus"

	# Set preference to include this file in the preflight check
	setreportpref "filevault_status" "${CACHEPATH}filevaultstatus.txt"
else
	echo "! Failed to install all required components"
	echo "! Skipping filevault status report"
	rm -f "${INSTALLROOT}/usr/local/bin/filevault_2_status_check.sh" \
		"${MUNKIPATH}preflight.d/filevaultstatus"
	# Set the exit status
	ERR=1
fi

