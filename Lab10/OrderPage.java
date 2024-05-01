import javax.imageio.ImageIO;
import javax.swing.*;
import javax.swing.table.*;
import java.awt.*;
import java.awt.event.*;
import java.awt.geom.Ellipse2D;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;

public class OrderPage extends JFrame {
    private JLabel nameLabel;
    private JLabel addressLabel;
    private JLabel contactLabel;
    private JLabel remarksLabel;
    private JTextField totalField; // Added totalField declaration

    public OrderPage(String name, String address, String contact, String remarks) {
        initComponents(name, address, contact, remarks);
    }

    private void initComponents(String name, String address, String contact, String remarks) {
        setTitle("Order Page");
        setDefaultCloseOperation(WindowConstants.DISPOSE_ON_CLOSE);
        setSize(690, 590);
        Color brownColor = new Color(228, 197, 158);
        getContentPane().setBackground(brownColor);

        setLayout(new GridBagLayout());

        GridBagConstraints constraints = new GridBagConstraints();
        constraints.anchor = GridBagConstraints.WEST;
        constraints.insets = new Insets(5, 5, 5, 5);

        nameLabel = new JLabel("Customer's Name: " + name);
        constraints.gridx = 0;
        constraints.gridy = 0;
        constraints.gridwidth = 1;
        add(nameLabel, constraints);

        addressLabel = new JLabel("Address: " + address);
        constraints.gridy = 1;
        add(addressLabel, constraints);

        contactLabel = new JLabel("Contact No.: " + contact);
        constraints.gridy = 2;
        add(contactLabel, constraints);

        remarksLabel = new JLabel("Remarks: " + remarks);
        constraints.gridy = 3;
        add(remarksLabel, constraints);

        JTabbedPane tabbedPane = new JTabbedPane();
        tabbedPane.addTab("Iced Coffee", createTablePanel("Iced Coffee"));
        tabbedPane.addTab("Frappe", createTablePanel("Frappe"));
        tabbedPane.addTab("Espresso", createTablePanel("Espresso"));
        tabbedPane.addTab("Latte", createTablePanel("Latte"));
        tabbedPane.addTab("Cappuccino", createTablePanel("Cappuccino"));
        constraints.gridx = 0;
        constraints.gridy = 7;
        constraints.gridwidth = 2;
        add(tabbedPane, constraints);

        try {
            BufferedImage logoImage = ImageIO.read(new File("logo1.png"));
            Image scaledLogoImage = logoImage.getScaledInstance(160, 160, Image.SCALE_SMOOTH);
            BufferedImage roundedLogoImage = new BufferedImage(160, 160, BufferedImage.TYPE_INT_ARGB);
            Graphics2D g2d = roundedLogoImage.createGraphics();
            g2d.setClip(new Ellipse2D.Float(0, 0, 160, 160));
            g2d.drawImage(scaledLogoImage, 0, 0, null);
            g2d.dispose();
            ImageIcon logoIcon = new ImageIcon(roundedLogoImage);
            JLabel logoLabel = new JLabel(logoIcon);
            constraints.gridx = 2;
            constraints.gridy = 0;
            add(logoLabel, constraints);
        } catch (IOException ex) {
            ex.printStackTrace();
        }

        JLabel totalAmountLabel = new JLabel("                          TOTAL:");
        totalAmountLabel.setFont(totalAmountLabel.getFont().deriveFont(Font.BOLD, totalAmountLabel.getFont().getSize() + 9f));
        totalAmountLabel.setForeground(Color.BLACK);
        totalAmountLabel.setOpaque(false);
        totalAmountLabel.setBackground(new Color(238, 228, 204));
        constraints.gridx = 1;
        constraints.gridy = 10;
        add(totalAmountLabel, constraints);

        totalField = new JTextField("0.00", 9);
        totalField.setEditable(false);
        totalField.setPreferredSize(new Dimension(totalField.getPreferredSize().width, totalField.getPreferredSize().height + 15));
        constraints.gridx = 2; // Adjusted gridx for totalField
        constraints.gridy = 10;
        constraints.gridwidth = 1;
        add(totalField, constraints);

        JButton addButton = new JButton("Add");
        addButton.setPreferredSize(new Dimension(100, 35));
        addButton.setFont(addButton.getFont().deriveFont(Font.BOLD, 15));
        addButton.setBackground(new Color(92, 64, 51));
        addButton.setForeground(Color.WHITE);
        addButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                Object[][] orderData = getOrderData(tabbedPane);
                displayOrderSummary(orderData, name, address, contact, remarks); // Pass customer info to order summary
                dispose();
            }
        });
        constraints.gridy++; // Adjusted gridy for addButton
        constraints.gridx = 2; // Adjusted gridx for addButton
        constraints.gridy = 11;
        constraints.anchor = GridBagConstraints.CENTER;
        add(addButton, constraints); // Added the Add button

        setVisible(true);
    }

    private JPanel createTablePanel(String type) {
        JPanel panel = new JPanel(new BorderLayout());

        String[] columnNames;
        Object[][] data;

        if (type.equals("Iced Coffee")) {
            columnNames = new String[]{"Select", "Choose Order", "Prices", "Quantity"};
            data = new Object[][]{
                    {false, "Iced Coffee, Cold, Small", "PHP25.00", ""},
                    {false, "Iced Coffee, Cold, Medium", "PHP50.00", ""},
                    {false, "Iced Coffee, Cold, Large", "PHP75.00", ""},
            };
        } else if (type.equals("Frappe")) {
            columnNames = new String[]{"Select", "Choose Order", "Prices", "Quantity"};
            data = new Object[][]{
                    {false, "Frappe, Hot, Small", "PHP60.00", ""},
                    {false, "Frappe, Hot, Medium", "PHP80.00", ""},
                    {false, "Frappe, Hot, Large", "PHP100.00", ""},
            };
        } else if (type.equals("Espresso")) {
            columnNames = new String[]{"Select", "Choose Order", "Prices", "Quantity"};
            data = new Object[][]{
                    {false, "Espresso, Hot, Small", "PHP40.00", ""},
                    {false, "Espresso, Hot, Medium", "PHP60.00", ""},
                    {false, "Espresso, Hot, Large", "PHP90.00", ""},
            };
        } else if (type.equals("Latte")) {
            columnNames = new String[]{"Select", "Choose Order", "Prices", "Quantity"};
            data = new Object[][]{
                    {false, "Latte, Hot, Small", "PHP80.00", ""},
                    {false, "Latte, Hot, Medium", "PHP100.00", ""},
                    {false, "Latte, Hot, Large", "PHP120.00", ""},
            };
        } else if (type.equals("Cappuccino")) {
            columnNames = new String[]{"Select", "Choose Order", "Prices", "Quantity"};
            data = new Object[][]{
                    {false, "Cappuccino, Hot, Small", "PHP70.00", ""},
                    {false, "Cappuccino, Hot, Medium", "PHP90.00", ""},
                    {false, "Cappuccino, Hot, Large", "PHP110.00", ""},
            };
        } else {
            // Default data
            columnNames = new String[]{"Choose Order", "Prices", "Quantity"};
            data = new Object[][]{{"", "", ""}};
        }

        DefaultTableModel model = new DefaultTableModel(data, columnNames) {
            @Override
            public Class<?> getColumnClass(int column) {
                return column == 0 ? Boolean.class : super.getColumnClass(column);
            }
        };

        JTable table = new JTable(model);
        table.getColumnModel().getColumn(3).setCellEditor(new QuantityCellEditor());
        table.setRowHeight(30);

        TableColumn checkBoxColumn = table.getColumnModel().getColumn(0);
        checkBoxColumn.setCellRenderer(table.getDefaultRenderer(Boolean.class));
        checkBoxColumn.setCellEditor(table.getDefaultEditor(Boolean.class));
        checkBoxColumn.setPreferredWidth(100);

        JTableHeader header = table.getTableHeader();
        header.setPreferredSize(new Dimension(header.getWidth(), 30));

        JScrollPane scrollPane = new JScrollPane(table);
        scrollPane.setPreferredSize(new Dimension(400, 124));
        panel.add(scrollPane, BorderLayout.CENTER);

        return panel;
    }

    private class QuantityCellEditor extends DefaultCellEditor {
        private JTextField textField;

        public QuantityCellEditor() {
            super(new JTextField());
            textField = (JTextField) getComponent();
            textField.setHorizontalAlignment(SwingConstants.RIGHT);
        }

        @Override
        public Component getTableCellEditorComponent(JTable table, Object value, boolean isSelected, int row, int column) {
            textField.setText((value != null) ? value.toString() : "");
            return textField;
        }

        @Override
        public Object getCellEditorValue() {
            return textField.getText();
        }
    }

    private Object[][] getOrderData(JTabbedPane tabbedPane) {
        DefaultTableModel model;
        Object[][] orderData = new Object[0][0];
        for (int i = 0; i < tabbedPane.getTabCount(); i++) {
            Component component = tabbedPane.getComponentAt(i);
            if (component instanceof JScrollPane) {
                JScrollPane scrollPane = (JScrollPane) component;
                JViewport viewport = scrollPane.getViewport();
                JTable table = (JTable) viewport.getView();
                model = (DefaultTableModel) table.getModel();
                for (int row = 0; row < model.getRowCount(); row++) {
                    Boolean selected = (Boolean) model.getValueAt(row, 0);
                    if (selected != null && selected) {
                        String item = (String) model.getValueAt(row, 1);
                        String price = (String) model.getValueAt(row, 2);
                        String quantity = (String) model.getValueAt(row, 3);
                        Object[] rowData = {item, quantity, price};
                        Object[][] temp = new Object[orderData.length + 1][];
                        System.arraycopy(orderData, 0, temp, 0, orderData.length);
                        temp[orderData.length] = rowData;
                        orderData = temp;
                    }
                }
            }
        }
        return orderData;
    }

    private void displayOrderSummary(Object[][] orderData, String name, String address, String contact, String remarks) {
        OrderSummaryPage orderSummaryPage = new OrderSummaryPage(name, address, contact, remarks, orderData);
        orderSummaryPage.setVisible(true);

        // Print selected rows to console for verification
        for (Object[] rowData : orderData) {
            for (Object item : rowData) {
                System.out.print(item + " ");
            }
            System.out.println();
        }
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(() -> {
            OrderPage orderPage = new OrderPage("Loved", "Philippines", "09XX-XXX-XXXX", "No remarks");
        });
    }
}
